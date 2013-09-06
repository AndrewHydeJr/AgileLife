//
//  ALCoreDataManager.m
//  AgileLife
//
//  Created by Andrew Hyde on 9/5/13.
//  Copyright (c) 2013 Andrew Hyde. All rights reserved.
//

#import "ALCoreDataManager.h"

@interface ALCoreDataManager ()
{
    NSManagedObjectModel *managedObjectModel;
    NSManagedObjectContext *managedObjectContext;
    NSPersistentStoreCoordinator *persistentStoreCoordinator;
}

- (NSString *)applicationDocumentsDirectory;

@property (nonatomic, retain, readonly) NSManagedObjectModel *managedObjectModel;
@property (nonatomic, retain, readonly) NSManagedObjectContext *managedObjectContext;
@property (nonatomic, retain, readonly) NSPersistentStoreCoordinator *persistentStoreCoordinator;

@end

@implementation ALCoreDataManager

@synthesize managedObjectContext, persistentStoreCoordinator;

static ALCoreDataManager *sharedInstance = nil;

+(ALCoreDataManager *)sharedInstance
{
    if (nil != sharedInstance) {
        return sharedInstance;
    }
    
    static dispatch_once_t pred;
    dispatch_once(&pred, ^{
        sharedInstance = [[ALCoreDataManager alloc] init];
    });
    
    return sharedInstance;
}

-(id)fetchForEntity:(NSString *)entityName withPredicate:(NSPredicate *)predicateRequest andSortDescriptor:(NSArray *)descriptor
{
    @synchronized(self)
    {
        NSManagedObjectContext *context = [[ALCoreDataManager sharedInstance] threadDependentManagedObjectContext];
        
        NSEntityDescription *entity = [NSEntityDescription
                                       entityForName:[NSString stringWithFormat:@"%@", entityName] inManagedObjectContext:context];
        if(!entity)
            return nil;
        
        NSFetchRequest *fetchRequest = [[NSFetchRequest alloc] init];
        
        [fetchRequest setEntity:entity];
        
        if(predicateRequest != nil)
            [fetchRequest setPredicate:predicateRequest];
        
        if(descriptor != nil)
            [fetchRequest setSortDescriptors:descriptor];
        
        NSError *error;
        if (context == nil)
            context = self.managedObjectContext;
        
        
        NSArray *fetchedObjects = [context executeFetchRequest:fetchRequest error:&error];

        return fetchedObjects;
    }
}

+(void)fetchEntity:(NSString *)entity withPredicate:(NSPredicate *)predicate completion:(CoreDataFetchBlock)block
{
    NSError *error = nil;
    NSFetchRequest *fetchRequest = [NSFetchRequest fetchRequestWithEntityName:entity];
    [fetchRequest setPredicate:predicate];
    NSArray *data = [[[ALCoreDataManager sharedInstance] threadDependentManagedObjectContext] executeFetchRequest:fetchRequest error:&error];
    
    block(data, error);
}

-(NSManagedObjectContext *)threadDependentManagedObjectContext
{
    NSManagedObjectContext *context = nil;
    if([NSThread isMainThread])
        context = self.managedObjectContext;
    else
    {
        NSManagedObjectContext *threadManagedObjectContext = nil;
        NSPersistentStoreCoordinator *coordinator = [self persistentStoreCoordinator];
        if (coordinator != nil) {
            threadManagedObjectContext = [[NSManagedObjectContext alloc] init];
            [threadManagedObjectContext setPersistentStoreCoordinator: coordinator];
        }
        
        context = threadManagedObjectContext;
    }
    return context;
}

-(BOOL)deleteEntityWithName:(NSString *)name
{
    NSManagedObjectContext *context = [[ALCoreDataManager sharedInstance] threadDependentManagedObjectContext];
    
    NSFetchRequest * deleteGroups = [[NSFetchRequest alloc] init];
    [deleteGroups setEntity:[NSEntityDescription entityForName:name inManagedObjectContext:context]];
    [deleteGroups setIncludesPropertyValues:NO]; //only fetch the managedObjectID
    
    NSError * error = nil;
    NSArray * groups = [context executeFetchRequest:deleteGroups error:&error];
    //error handling goes here
    for (NSManagedObject * group in groups)
        [context deleteObject:group];
    
    NSError *saveError = nil;
    if(![context save:&saveError])
        return NO;
    else
        return YES;
}

#pragma mark -
#pragma mark Core Data

//Explicitly write Core Data accessors
- (NSManagedObjectContext *) managedObjectContext {
    NSManagedObjectContext *context = nil;
    if (managedObjectContext != nil)
    {
        context = managedObjectContext;
    }
    else
    {
        NSPersistentStoreCoordinator *coordinator = [self persistentStoreCoordinator];
        if (coordinator != nil)
        {
            managedObjectContext = [[NSManagedObjectContext alloc] init];
            [managedObjectContext setPersistentStoreCoordinator: coordinator];
        }
        context = managedObjectContext;
    }
    return context;
}

- (NSManagedObjectModel *)managedObjectModel {
    if (managedObjectModel != nil)
        return managedObjectModel;

    managedObjectModel = [NSManagedObjectModel mergedModelFromBundles:nil];
    
    return managedObjectModel;
}

- (NSPersistentStoreCoordinator *)persistentStoreCoordinator {
    if (persistentStoreCoordinator != nil)
        return persistentStoreCoordinator;

    NSURL *storeUrl = [NSURL fileURLWithPath: [[self applicationDocumentsDirectory]
                                               stringByAppendingPathComponent: @"AgileLife.sqlite"]];
    NSError *error = nil;
    persistentStoreCoordinator = [[NSPersistentStoreCoordinator alloc]
                                  initWithManagedObjectModel:[self managedObjectModel]];
    if(![persistentStoreCoordinator addPersistentStoreWithType:NSSQLiteStoreType
                                                 configuration:nil URL:storeUrl options:nil error:&error]) {
        /*Error for store creation should be handled in here*/
    }
    
    return persistentStoreCoordinator;
}

- (NSString *)applicationDocumentsDirectory {
    return [NSSearchPathForDirectoriesInDomains(NSDocumentDirectory, NSUserDomainMask, YES) lastObject];
}

@end
