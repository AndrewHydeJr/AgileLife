//
//  Task.h
//  AgileLife
//
//  Created by Andrew Hyde on 9/5/13.
//  Copyright (c) 2013 Andrew Hyde. All rights reserved.
//

#import <Foundation/Foundation.h>
#import <CoreData/CoreData.h>


@interface Task : NSManagedObject

@property (nonatomic, retain) NSString * title;
@property (nonatomic, retain) NSString * state;
@property (nonatomic, retain) NSNumber * estimate;
@property (nonatomic, retain) NSNumber * order;
@property (nonatomic, retain) NSNumber * loggedHours;
@property (nonatomic, retain) NSManagedObject *lane;
@property (nonatomic, retain) NSManagedObject *owner;

@end
