//
//  ALFeedManager.h
//  AgileLife
//
//  Created by Andrew Hyde on 9/6/13.
//  Copyright (c) 2013 Andrew Hyde. All rights reserved.
//

#import <Foundation/Foundation.h>

typedef void(^FeedManagerCompletion)(id data, NSError *error);

@interface ALFeedManager : NSObject

+(void)fetchFullUpdateForUserWithUID:(NSString *)uid andCompletion:(FeedManagerCompletion)block;

//USER
+(void)createUserWithInfo:(NSDictionary *)info andCompletion:(FeedManagerCompletion)block;
+(void)fetchAllUsersWithCompletion:(FeedManagerCompletion)block;
+(void)updateUserWithUID:(NSString *)uid withInfo:(NSDictionary *)info andCompletion:(FeedManagerCompletion)block;
+(void)deleteUserWithUID:(NSString *)uid andCompletion:(FeedManagerCompletion)block;

//BOARD
+(void)createBoardForUserWithUID:(NSString *)uid withInfo:(NSDictionary *)info andCompletion:(FeedManagerCompletion)block;
+(void)fetchBoardsForUserWithUID:(NSString *)uid andCompletion:(FeedManagerCompletion)block;
+(void)updateBoardWithUID:(NSString *)uid withInfo:(NSDictionary *)info andCompletion:(FeedManagerCompletion)block;
+(void)deleteBoardWithUID:(NSString *)uid andCompletion:(FeedManagerCompletion)block;

//LANE
+(void)createLaneForBoardWithUID:(NSString *)uid withInfo:(NSDictionary *)info andCompletion:(FeedManagerCompletion)block;
+(void)fetchLanesForBoardWithUID:(NSString *)uid andCompletion:(FeedManagerCompletion)block;
+(void)updateLaneWithUID:(NSString *)uid withInfo:(NSDictionary *)info andCompletion:(FeedManagerCompletion)block;
+(void)deleteLaneWithUID:(NSString *)uid andCompletion:(FeedManagerCompletion)block;

//TASK
+(void)createTaskForLaneWithUID:(NSString *)uid withInfo:(NSDictionary *)info andCompletion:(FeedManagerCompletion)block;
+(void)fetchTaskForLaneWithUID:(NSString *)uid andCompletion:(FeedManagerCompletion)block;
+(void)updateTaskWithUID:(NSString *)uid withInfo:(NSDictionary *)info andCompletion:(FeedManagerCompletion)block;
+(void)deleteTaskWithUID:(NSString *)uid andCompletion:(FeedManagerCompletion)block;


@end
