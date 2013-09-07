//
//  ALFeedManager.m
//  AgileLife
//
//  Created by Andrew Hyde on 9/6/13.
//  Copyright (c) 2013 Andrew Hyde. All rights reserved.
//

#import "ALFeedManager.h"

#define BASE_URL @"http://agilelife.com"

@implementation ALFeedManager

+(void)fetchFullUpdateForUserWithUID:(NSString *)uid andCompletion:(FeedManagerCompletion)block
{
    NSString *url = [NSString stringWithFormat:@"%@/fullUpdate?userUID=%@", BASE_URL, uid];
    NSMutableURLRequest *request = [NSMutableURLRequest requestWithURL:[NSURL URLWithString:url]];
    [self loadDataFromRequest:request withBlock:^(NSData *data, NSError *error) {
        [self dictionaryFromJSONData:data andCompletion:block];
    }];
}

#pragma mark - USER

+(void)createUserWithInfo:(NSDictionary *)info andCompletion:(FeedManagerCompletion)block
{
    NSString *url = [NSString stringWithFormat:@"%@/create/user", BASE_URL];
    NSMutableURLRequest *request = [NSMutableURLRequest requestWithURL:[NSURL URLWithString:url]];
    
#warning [AH] Set up the post body
    
    [self loadDataFromRequest:request withBlock:^(NSData *data, NSError *error) {
        [self dictionaryFromJSONData:data andCompletion:block];
    }];
}
+(void)fetchUsersWithCompletion:(FeedManagerCompletion)block
{
    NSString *url = [NSString stringWithFormat:@"%@/fetch/users", BASE_URL];
    NSMutableURLRequest *request = [NSMutableURLRequest requestWithURL:[NSURL URLWithString:url]];
    [self loadDataFromRequest:request withBlock:^(NSData *data, NSError *error) {
        [self dictionaryFromJSONData:data andCompletion:block];
    }];
}
+(void)updateUserWithUID:(NSString *)uid withInfo:(NSDictionary *)info andCompletion:(FeedManagerCompletion)block
{
    NSString *url = [NSString stringWithFormat:@"%@/update/user?uid=%@", BASE_URL, uid];
    NSMutableURLRequest *request = [NSMutableURLRequest requestWithURL:[NSURL URLWithString:url]];
    
#warning [AH] Set up the post body
    
    [self loadDataFromRequest:request withBlock:^(NSData *data, NSError *error) {
        [self dictionaryFromJSONData:data andCompletion:block];
    }];
}
+(void)deleteUserWithUID:(NSString *)uid andCompletion:(FeedManagerCompletion)block
{
    NSString *url = [NSString stringWithFormat:@"%@/delete/user?uid=%@", BASE_URL, uid];
    NSMutableURLRequest *request = [NSMutableURLRequest requestWithURL:[NSURL URLWithString:url]];
    [self loadDataFromRequest:request withBlock:^(NSData *data, NSError *error) {
        [self dictionaryFromJSONData:data andCompletion:block];
    }];
}

//BOARD
+(void)createBoardForUserWithUID:(NSString *)uid withInfo:(NSDictionary *)info andCompletion:(FeedManagerCompletion)block
{
    NSString *url = [NSString stringWithFormat:@"%@/create/board", BASE_URL];
    NSMutableURLRequest *request = [NSMutableURLRequest requestWithURL:[NSURL URLWithString:url]];
    
#warning [AH] Set up the post body
    
    [self loadDataFromRequest:request withBlock:^(NSData *data, NSError *error) {
        [self dictionaryFromJSONData:data andCompletion:block];
    }];
}
+(void)fetchBoardsForUserWithUID:(NSString *)uid andCompletion:(FeedManagerCompletion)block
{
    NSString *url = [NSString stringWithFormat:@"%@/fetch/boards?userUID=%@", BASE_URL, uid];
    NSMutableURLRequest *request = [NSMutableURLRequest requestWithURL:[NSURL URLWithString:url]];
    [self loadDataFromRequest:request withBlock:^(NSData *data, NSError *error) {
        [self dictionaryFromJSONData:data andCompletion:block];
    }];
}
+(void)updateBoardWithUID:(NSString *)uid withInfo:(NSDictionary *)info andCompletion:(FeedManagerCompletion)block
{
    NSString *url = [NSString stringWithFormat:@"%@/update/board?uid=%@", BASE_URL, uid];
    NSMutableURLRequest *request = [NSMutableURLRequest requestWithURL:[NSURL URLWithString:url]];
    
#warning [AH] Set up the post body
    
    [self loadDataFromRequest:request withBlock:^(NSData *data, NSError *error) {
        [self dictionaryFromJSONData:data andCompletion:block];
    }];
}
+(void)deleteBoardWithUID:(NSString *)uid andCompletion:(FeedManagerCompletion)block
{
    NSString *url = [NSString stringWithFormat:@"%@/delete/board?uid=%@", BASE_URL, uid];
    NSMutableURLRequest *request = [NSMutableURLRequest requestWithURL:[NSURL URLWithString:url]];
    [self loadDataFromRequest:request withBlock:^(NSData *data, NSError *error) {
        [self dictionaryFromJSONData:data andCompletion:block];
    }];
}

//LANE
+(void)createLaneForBoardWithUID:(NSString *)uid withInfo:(NSDictionary *)info andCompletion:(FeedManagerCompletion)block
{
    NSString *url = [NSString stringWithFormat:@"%@/create/lane", BASE_URL];
    NSMutableURLRequest *request = [NSMutableURLRequest requestWithURL:[NSURL URLWithString:url]];
    
#warning [AH] Set up the post body
    
    [self loadDataFromRequest:request withBlock:^(NSData *data, NSError *error) {
        [self dictionaryFromJSONData:data andCompletion:block];
    }];
}
+(void)fetchLanesForBoardWithUID:(NSString *)uid andCompletion:(FeedManagerCompletion)block
{
    NSString *url = [NSString stringWithFormat:@"%@/fetch/lane?boardUID=%@", BASE_URL, uid];
    NSMutableURLRequest *request = [NSMutableURLRequest requestWithURL:[NSURL URLWithString:url]];
    [self loadDataFromRequest:request withBlock:^(NSData *data, NSError *error) {
        [self dictionaryFromJSONData:data andCompletion:block];
    }];
}
+(void)updateLaneWithUID:(NSString *)uid withInfo:(NSDictionary *)info andCompletion:(FeedManagerCompletion)block
{
    NSString *url = [NSString stringWithFormat:@"%@/update/lane?uid=%@", BASE_URL, uid];
    NSMutableURLRequest *request = [NSMutableURLRequest requestWithURL:[NSURL URLWithString:url]];
    
#warning [AH] Set up the post body
    
    [self loadDataFromRequest:request withBlock:^(NSData *data, NSError *error) {
        [self dictionaryFromJSONData:data andCompletion:block];
    }];
}
+(void)deleteLaneWithUID:(NSString *)uid andCompletion:(FeedManagerCompletion)block
{
    NSString *url = [NSString stringWithFormat:@"%@/delete/lane?uid=%@", BASE_URL, uid];
    NSMutableURLRequest *request = [NSMutableURLRequest requestWithURL:[NSURL URLWithString:url]];
    [self loadDataFromRequest:request withBlock:^(NSData *data, NSError *error) {
        [self dictionaryFromJSONData:data andCompletion:block];
    }];
}

#pragma mark - TASKS

+(void)createTaskForLaneWithUID:(NSString *)uid withInfo:(NSDictionary *)info andCompletion:(FeedManagerCompletion)block
{
    NSString *url = [NSString stringWithFormat:@"%@/create/task", BASE_URL];
    NSMutableURLRequest *request = [NSMutableURLRequest requestWithURL:[NSURL URLWithString:url]];
    
#warning [AH] Set up the post body 
    
    [self loadDataFromRequest:request withBlock:^(NSData *data, NSError *error) {
        [self dictionaryFromJSONData:data andCompletion:block];
    }];
}
+(void)fetchTasksForLaneWithUID:(NSString *)uid andCompletion:(FeedManagerCompletion)block
{
    NSString *url = [NSString stringWithFormat:@"%@/fetch/tasks?laneUID=%@", BASE_URL, uid];
    NSMutableURLRequest *request = [NSMutableURLRequest requestWithURL:[NSURL URLWithString:url]];
    [self loadDataFromRequest:request withBlock:^(NSData *data, NSError *error) {
        [self dictionaryFromJSONData:data andCompletion:block];
    }];
}
+(void)updateTaskWithUID:(NSString *)uid withInfo:(NSDictionary *)info andCompletion:(FeedManagerCompletion)block
{
    NSString *url = [NSString stringWithFormat:@"%@/update/task?uid=%@", BASE_URL, uid];
    NSMutableURLRequest *request = [NSMutableURLRequest requestWithURL:[NSURL URLWithString:url]];
    
#warning [AH] Set up the post body    
    
    [self loadDataFromRequest:request withBlock:^(NSData *data, NSError *error) {
        [self dictionaryFromJSONData:data andCompletion:block];
    }];
}
+(void)deleteTaskWithUID:(NSString *)uid andCompletion:(FeedManagerCompletion)block
{
    NSString *url = [NSString stringWithFormat:@"%@/delete/task?uid=%@", BASE_URL, uid];
    NSMutableURLRequest *request = [NSMutableURLRequest requestWithURL:[NSURL URLWithString:url]];
    [self loadDataFromRequest:request withBlock:^(NSData *data, NSError *error) {
        [self dictionaryFromJSONData:data andCompletion:block];
    }];
}

#pragma mark - NETWORKING

typedef void (^NetworkingBlock)(NSData *data, NSError *error);

+(void)loadDataFromRequest:(NSMutableURLRequest *)request withBlock:(NetworkingBlock)block
{
    //iOS 5+
    if([NSURLConnection respondsToSelector:@selector(sendAsynchronousRequest:queue:completionHandler:)])
    {
        [NSURLConnection sendAsynchronousRequest:request
                                           queue:[NSOperationQueue mainQueue]
                               completionHandler:
         ^(NSURLResponse *response, NSData *data, NSError *error)
         {
             int statusCode = [(NSHTTPURLResponse *)response statusCode];
             
             if(statusCode < 200 || statusCode > 300)
                 error = [NSError errorWithDomain:@"Invalid Response Code" code:statusCode userInfo:nil];
             
             if(block)
                 block(data, error);
         }];
    }
    else    //pre iOS 5
    {
        dispatch_async(dispatch_get_global_queue(DISPATCH_QUEUE_PRIORITY_DEFAULT, 0),
                       ^{
                           NSError *error = nil;
                           NSURLResponse *urlResponse = nil;
                           NSData *responseData =
                           [NSURLConnection sendSynchronousRequest:request returningResponse:&urlResponse error:&error];
                           
                           int statusCode = [(NSHTTPURLResponse *)urlResponse statusCode];
                           
                           if(statusCode < 200 && statusCode > 300)
                               error = [NSError errorWithDomain:@"Invalid Response Code" code:statusCode userInfo:nil];
                           
                           dispatch_async(dispatch_get_main_queue(),
                                          ^{
                                              if(block)
                                                  block(responseData, error);
                                          });
                       });
    }
}

#pragma mark - UTILTIES

+(void)dictionaryFromJSONData:(NSData *)data andCompletion:(FeedManagerCompletion)block
{
    NSError *error = nil;
    NSDictionary *returnDict = [NSJSONSerialization JSONObjectWithData:data options:NSJSONReadingAllowFragments error:&error];
    
    block(returnDict, error);
}

@end
