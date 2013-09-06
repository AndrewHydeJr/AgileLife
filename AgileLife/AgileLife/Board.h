//
//  Board.h
//  AgileLife
//
//  Created by Andrew Hyde on 9/5/13.
//  Copyright (c) 2013 Andrew Hyde. All rights reserved.
//

#import <Foundation/Foundation.h>
#import <CoreData/CoreData.h>

@class Lane;

@interface Board : NSManagedObject

@property (nonatomic, retain) NSString * name;
@property (nonatomic, retain) NSManagedObject *user;
@property (nonatomic, retain) NSSet *lanes;
@end

@interface Board (CoreDataGeneratedAccessors)

- (void)addLanesObject:(Lane *)value;
- (void)removeLanesObject:(Lane *)value;
- (void)addLanes:(NSSet *)values;
- (void)removeLanes:(NSSet *)values;

@end
