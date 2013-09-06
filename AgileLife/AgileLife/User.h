//
//  User.h
//  AgileLife
//
//  Created by Andrew Hyde on 9/6/13.
//  Copyright (c) 2013 Andrew Hyde. All rights reserved.
//

#import <Foundation/Foundation.h>
#import <CoreData/CoreData.h>

@class Board, Task;

@interface User : NSManagedObject

@property (nonatomic, retain) NSString * name;
@property (nonatomic, retain) NSSet *boards;
@property (nonatomic, retain) NSSet *tasks;
@end

@interface User (CoreDataGeneratedAccessors)

- (void)addBoardsObject:(Board *)value;
- (void)removeBoardsObject:(Board *)value;
- (void)addBoards:(NSSet *)values;
- (void)removeBoards:(NSSet *)values;

- (void)addTasksObject:(Task *)value;
- (void)removeTasksObject:(Task *)value;
- (void)addTasks:(NSSet *)values;
- (void)removeTasks:(NSSet *)values;

@end
