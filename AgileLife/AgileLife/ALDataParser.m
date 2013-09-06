//
//  ALDataParser.m
//  AgileLife
//
//  Created by Andrew Hyde on 9/5/13.
//  Copyright (c) 2013 Andrew Hyde. All rights reserved.
//

#import "ALDataParser.h"
#import "ALCoreDataManager.h"
#import "User.h"
#import "Board.h"
#import "Lane.h"
#import "Task.h"

@implementation ALDataParser

+(void)parseDictionary:(NSDictionary *)dictionary withCompletion:(DataParserBlock)completion
{
    NSManagedObjectContext *context = [[ALCoreDataManager sharedInstance] threadDependentManagedObjectContext];
    
    NSDictionary *userData = dictionary[@"user"];
    if(userData)
    {
        User *user = [self getOrCreateUserWithName:userData[@"name"] inContext:context];
        
        NSArray *boards = userData[@"boards"];
        for(NSDictionary *boardData in boards)
        {
            Board *board = [self getOrCreateBoardWithName:boardData[@"name"] forUser:user inContext:context];
            
            NSArray *lanes = boardData[@"lanes"];
            int laneCount = 0;
            for(NSDictionary *lanesData in lanes)
            {
                Lane *lane = [self getOrCreateLaneWithTitle:lanesData[@"title"] forBoard:board inContext:context];
                lane.order = [NSNumber numberWithInt:laneCount];
                
                NSArray *tasks = lanesData[@"tasks"];
                int taskCount = 0;
                for(NSDictionary *taskData in tasks)
                {
                    Task *task = [self getOrCreateTaskWithTitle:taskData[@"title"] forLane:lane inContext:context];
                    task.estimate = taskData[@"estimate"];
                    task.loggedHours = taskData[@"loggedhours"];
                    task.owner = user;
                    task.order = [NSNumber numberWithInt:taskCount];
                    taskCount++;
                }
                
                laneCount++;
            }
        }
        
        NSError *error = nil;
        [context save:&error];
        completion(error);
    }
    else
        completion([NSError errorWithDomain:@"Parsing - No dictionary Provided" code:1 userInfo:nil]);
}

#pragma mark - UTILITIES

#warning [AH] REFACTOR THIS INTO ADDITIONS CATEGORY

+(User *)getOrCreateUserWithName:(NSString *)name inContext:(NSManagedObjectContext *)context
{
    NSError *error = nil;
    NSFetchRequest *fetchRequest = [NSFetchRequest fetchRequestWithEntityName:@"User"];
    [fetchRequest setPredicate:[NSPredicate predicateWithFormat:[NSString stringWithFormat:@"name == '%@'", name]]];
    NSArray *users = [[[ALCoreDataManager sharedInstance] threadDependentManagedObjectContext] executeFetchRequest:fetchRequest error:&error];
    
    if([users count] > 0)
    {
        User *user = (User *)[users firstObject];
        return user;
    }
    else
    {
        User *user = [NSEntityDescription insertNewObjectForEntityForName:@"User" inManagedObjectContext:context];
        user.name = name;
        return user;
    }
}

+(Board *)getOrCreateBoardWithName:(NSString *)name forUser:(User *)user inContext:(NSManagedObjectContext *)context
{
    NSError *error = nil;
    NSFetchRequest *fetchRequest = [NSFetchRequest fetchRequestWithEntityName:@"Board"];
    [fetchRequest setPredicate:[NSPredicate predicateWithFormat:[NSString stringWithFormat:@"name == '%@'", name]]];
    NSArray *boards = [[[ALCoreDataManager sharedInstance] threadDependentManagedObjectContext] executeFetchRequest:fetchRequest error:&error];
    if([boards count] > 0)
    {
        Board *board = [boards firstObject];
        board.user = user;
        return board;
    }
    else
    {
        Board *board = [NSEntityDescription insertNewObjectForEntityForName:@"Board" inManagedObjectContext:context];
        board.user = user;
        board.name = name;
        return board;
    }
}

+(Lane *)getOrCreateLaneWithTitle:(NSString *)title forBoard:(Board *)board inContext:(NSManagedObjectContext *)context
{
    NSError *error = nil;
    NSFetchRequest *fetchRequest = [NSFetchRequest fetchRequestWithEntityName:@"Lane"];
    [fetchRequest setPredicate:[NSPredicate predicateWithFormat:[NSString stringWithFormat:@"title == '%@'", title]]];
    NSArray *lanes = [[[ALCoreDataManager sharedInstance] threadDependentManagedObjectContext] executeFetchRequest:fetchRequest error:&error];
    if([lanes count] > 0)
    {
        Lane *lane = [lanes firstObject];
        return lane;
    }
    else
    {
        Lane *lane = [NSEntityDescription insertNewObjectForEntityForName:@"Lane" inManagedObjectContext:context];
        lane.board = board;
        lane.title = title;
        return lane;
    }
}

+(Task *)getOrCreateTaskWithTitle:(NSString *)title forLane:(Lane *)lane inContext:(NSManagedObjectContext *)context
{
    NSError *error = nil;
    NSFetchRequest *fetchRequest = [NSFetchRequest fetchRequestWithEntityName:@"Task"];
    [fetchRequest setPredicate:[NSPredicate predicateWithFormat:[NSString stringWithFormat:@"title == '%@'", title]]];
    NSArray *tasks = [[[ALCoreDataManager sharedInstance] threadDependentManagedObjectContext] executeFetchRequest:fetchRequest error:&error];

    if([tasks count] > 0)
    {
        Task *task = [tasks firstObject];
        task.lane = lane;
        return task;
    }
    else
    {
        Task *task = [NSEntityDescription insertNewObjectForEntityForName:@"Task" inManagedObjectContext:context];
        task.lane = lane;
        task.title = title;
        return task;
    }
}

@end
