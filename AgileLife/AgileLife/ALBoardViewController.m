//
//  ALBoardViewController.m
//  AgileLife
//
//  Created by Andrew Hyde on 9/5/13.
//  Copyright (c) 2013 Andrew Hyde. All rights reserved.
//

#import "ALBoardViewController.h"

#import "ALCoreDataManager.h"
#import "UIView+Additions.h"
#import "ALDataParser.h"
#import "Board.h"
#import "Lane.h"
#import "Task.h"
#import "Lane+SortedTasks.h"
#import "ALCreateTaskViewController.h"

@interface ALBoardViewController ()

@property (nonatomic) NSArray *currentLanes;
@property (nonatomic) Board *currentBoard;

@end

@implementation ALBoardViewController

- (id)initWithStyle:(UITableViewStyle)style
{
    self = [super initWithStyle:style];
    if (self) {
        // Custom initialization
    }
    return self;
}

-(void)viewDidAppear:(BOOL)animated
{
    [self reloadData];
}

- (void)viewDidLoad
{
    [super viewDidLoad];
    
    [self.tableView setEditing:YES];
    UIRefreshControl *refreshControl = [[UIRefreshControl alloc] init];
    [refreshControl addTarget:self action:@selector(refresh:) forControlEvents:UIControlEventValueChanged];
    [self.tableView addSubview:refreshControl];
    
    UIBarButtonItem *item = [[UIBarButtonItem alloc]initWithTitle:@"+" style:UIBarButtonItemStylePlain target:self action:@selector(addTicket:)];
    self.navigationItem.rightBarButtonItem = item;
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

#pragma mark - ACTIONS

-(IBAction)addTicket:(id)sender
{
    ALCreateTaskViewController *addTask = [[ALCreateTaskViewController alloc]init];
    addTask.modalTransitionStyle = UIModalTransitionStyleFlipHorizontal;
    addTask.board = self.currentBoard;
    [self presentViewController:addTask animated:YES completion:nil];
}

#pragma mark - SETTERS

-(void)setCurrentLanes:(NSArray *)currentLanes
{
    _currentLanes = currentLanes;
    [self.tableView reloadData];
}

#pragma mark - REFRESH CONTROL

- (void)refresh:(UIRefreshControl *)refreshControl {
    [self loadData];
    [refreshControl endRefreshing];
}

#pragma mark - LOADING

-(void)reloadData
{
    [ALCoreDataManager fetchEntity:@"Board" withPredicate:nil completion:^(NSArray *array, NSError *error){
        self.currentBoard = [array firstObject];
        self.title = self.currentBoard.name;
        self.currentBoard = self.currentBoard;
        self.currentLanes = [self.currentBoard.lanes sortedArrayUsingDescriptors:@[[NSSortDescriptor sortDescriptorWithKey:@"order" ascending:YES]]];
    }];
}

-(void)loadData
{
    NSDictionary *dict = [[self class] getDictionaryForFeed:@"TestData"];
    [ALDataParser parseDictionary:dict withCompletion:^(NSError *error) {
        [self reloadData];
    }];
}

#pragma mark - Table view data source

- (NSInteger)numberOfSectionsInTableView:(UITableView *)tableView
{
    return [self.currentLanes count];
}

- (NSInteger)tableView:(UITableView *)tableView numberOfRowsInSection:(NSInteger)section
{
    Lane *lane = self.currentLanes[section];
    return [lane.tasks count];
}

- (UITableViewCell *)tableView:(UITableView *)tableView cellForRowAtIndexPath:(NSIndexPath *)indexPath
{
    Lane *lane = self.currentLanes[indexPath.section];
    Task *task = lane.sortedTasks[indexPath.row];
    
    static NSString *cellIdentifier = @"Cell";
    UITableViewCell *cell = [tableView dequeueReusableCellWithIdentifier:cellIdentifier];
    if(!cell)
        cell = [[UITableViewCell alloc]initWithStyle:UITableViewCellStyleDefault reuseIdentifier:cellIdentifier];

    cell.showsReorderControl = NO;
    [cell.textLabel setText:task.title];
    
    return cell;
}

-(UITableViewCellEditingStyle)tableView:(UITableView *)tableView editingStyleForRowAtIndexPath:(NSIndexPath *)indexPath
{
    return UITableViewCellEditingStyleNone;
}

- (BOOL) tableView:(UITableView *)tableView shouldIndentWhileEditingRowAtIndexPath:(NSIndexPath *)indexPath
{
	return NO;
}

- (UIView *)tableView:(UITableView *)tableView viewForHeaderInSection:(NSInteger)section
{
    Lane *lane = self.currentLanes[section];
    
    UILabel *label = [[UILabel alloc]initWithFrame:CGRectMake(0, 0, tableView.frame.size.width, 20)];
    label.backgroundColor = [UIColor colorWithHue:0 saturation:0 brightness:0 alpha:.1];
    label.text = lane.title;
    
    return label;
}

// Override to support rearranging the table view.
- (void)tableView:(UITableView *)tableView moveRowAtIndexPath:(NSIndexPath *)fromIndexPath toIndexPath:(NSIndexPath *)toIndexPath
{
    Lane *lane = self.currentLanes[fromIndexPath.section];
    Task *task = lane.sortedTasks[fromIndexPath.row];
    Lane *toLane = self.currentLanes[toIndexPath.section];
    
    NSManagedObjectContext *context = [[ALCoreDataManager sharedInstance] threadDependentManagedObjectContext];
    
    Lane *contextToLane = (Lane *)[context objectWithID:toLane.objectID];
    Task *contextToTask = (Task *)[context objectWithID:task.objectID];
    
    contextToTask.lane = contextToLane;
    
    NSError *error = nil;
    if([context save:&error])
       [self.tableView reloadData];
}

// Override to support conditional rearranging of the table view.
- (BOOL)tableView:(UITableView *)tableView canMoveRowAtIndexPath:(NSIndexPath *)indexPath
{
    return YES;
}

- (void) tableView:(UITableView *)tableView willDisplayCell:(UITableViewCell *)cell forRowAtIndexPath:(NSIndexPath *)indexPath
{
	UIView* reorderControl = [cell subviewWithClassName:@"UITableViewCellReorderControl"];
    
	UIView* resizedGripView = [[UIView alloc] initWithFrame:CGRectMake(0, 0, CGRectGetMaxX(reorderControl.frame), CGRectGetMaxY(reorderControl.frame))];
	[resizedGripView addSubview:reorderControl];
	[cell addSubview:resizedGripView];
    
	CGSize sizeDifference = CGSizeMake(resizedGripView.frame.size.width - reorderControl.frame.size.width, resizedGripView.frame.size.height - reorderControl.frame.size.height);
	CGSize transformRatio = CGSizeMake(resizedGripView.frame.size.width / reorderControl.frame.size.width, resizedGripView.frame.size.height / reorderControl.frame.size.height);

	CGAffineTransform transform = CGAffineTransformIdentity;
    
	transform = CGAffineTransformScale(transform, transformRatio.width, transformRatio.height);

	transform = CGAffineTransformTranslate(transform, -sizeDifference.width / 2.0, -sizeDifference.height / 2.0);
    
	[resizedGripView setTransform:transform];
    
	for(UIImageView* cellGrip in reorderControl.subviews)
	{
		if([cellGrip isKindOfClass:[UIImageView class]])
			[cellGrip setImage:nil];
	}
}

#pragma mark - UTILITIES

+(NSDictionary *)getDictionaryForFeed:(NSString *)feed
{
    NSError *error = nil;
    NSString *path = [[NSBundle mainBundle] pathForResource:feed ofType:@"txt"];
    NSString *fileText = [NSString stringWithContentsOfFile:path encoding:NSUTF8StringEncoding error:&error];
    
    NSDictionary *dictionary = nil;
    if(fileText)
        dictionary = [NSJSONSerialization JSONObjectWithData:[fileText dataUsingEncoding:NSUTF8StringEncoding] options:NSJSONReadingMutableContainers error:&error];
    
    return dictionary;
}

@end
