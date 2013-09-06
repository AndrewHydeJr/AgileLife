//
//  Task+SortedTasks.m
//  AgileLife
//
//  Created by Andrew Hyde on 9/5/13.
//  Copyright (c) 2013 Andrew Hyde. All rights reserved.
//

#import "Lane+SortedTasks.h"

@implementation Lane (SortedTasks)

-(NSArray *)sortedTasks
{
    NSArray *tasks = [self.tasks allObjects];
    tasks = [tasks sortedArrayUsingDescriptors:@[[NSSortDescriptor sortDescriptorWithKey:@"order" ascending:YES]]];
    return tasks;
}

@end
