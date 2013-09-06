//
//  ALCoreDataManager.h
//  AgileLife
//
//  Created by Andrew Hyde on 9/5/13.
//  Copyright (c) 2013 Andrew Hyde. All rights reserved.
//

#import <Foundation/Foundation.h>
#import <CoreData/CoreData.h>

typedef void (^CoreDataFetchBlock)(NSArray *, NSError *);

@interface ALCoreDataManager : NSObject

+(ALCoreDataManager *)sharedInstance;
-(NSManagedObjectContext *)threadDependentManagedObjectContext;
-(id)fetchForEntity:(NSString *)entityName withPredicate:(NSPredicate *)predicateRequest andSortDescriptor:(NSArray *)descriptor;
+(void)fetchEntity:(NSString *)entity withPredicate:(NSPredicate *)predicate completion:(CoreDataFetchBlock)block;

@end
