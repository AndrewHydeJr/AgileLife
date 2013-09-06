//
//  Task+SortedTasks.h
//  AgileLife
//
//  Created by Andrew Hyde on 9/5/13.
//  Copyright (c) 2013 Andrew Hyde. All rights reserved.
//

#import "Lane.h"

@interface Lane (SortedTasks)

@property(nonatomic, readonly)NSArray *sortedTasks;

@end
