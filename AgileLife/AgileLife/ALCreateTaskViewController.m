//
//  ALCreateTaskViewController.m
//  AgileLife
//
//  Created by Andrew Hyde on 9/5/13.
//  Copyright (c) 2013 Andrew Hyde. All rights reserved.
//

#import "ALCreateTaskViewController.h"
#import "ALCoreDataManager.h"
#import "Task.h"
#import "Lane.h"

@interface ALCreateTaskViewController ()

@property (nonatomic) UITextField *titleField;
@property (nonatomic) UITextField *estimate;

@end

@implementation ALCreateTaskViewController

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        
        self.view.backgroundColor = [UIColor whiteColor];
        
        // Custom initialization
    }
    return self;
}

- (void)viewDidLoad
{
    [super viewDidLoad];
    
    self.titleField = [[UITextField alloc]initWithFrame:CGRectMake(10, 70, self.view.frame.size.width-20, 30)];
    self.titleField.borderStyle = UITextBorderStyleBezel;
    self.titleField.placeholder = @"Title";
    [self.view addSubview:self.titleField];
    
    self.estimate = [[UITextField alloc]initWithFrame:CGRectMake(10, 110, self.view.frame.size.width-20, 30)];
    self.estimate.borderStyle = UITextBorderStyleBezel;
    self.estimate.placeholder = @"Estimate";
    [self.view addSubview:self.estimate];
    
    UIButton *saveButton = [UIButton buttonWithType:UIButtonTypeSystem];
    [saveButton setTitle:@"Save" forState:UIControlStateNormal];
    [saveButton setFrame:CGRectMake(10, 30, 100, 34)];
    [saveButton sizeToFit];
    [saveButton addTarget:self action:@selector(saveButtonPressed:) forControlEvents:UIControlEventTouchUpInside];
    [self.view addSubview:saveButton];
    
    UIButton *dismissButton = [UIButton buttonWithType:UIButtonTypeSystem];
    [dismissButton setTitle:@"Cancel" forState:UIControlStateNormal];
    [dismissButton setFrame:CGRectMake(260, 30, 100, 34)];
    [dismissButton sizeToFit];
    [dismissButton addTarget:self action:@selector(dismissButtonPressed:) forControlEvents:UIControlEventTouchUpInside];
    [self.view addSubview:dismissButton];
    
	// Do any additional setup after loading the view.
}

-(IBAction)saveButtonPressed:(id)sender
{
    NSManagedObjectContext *context = [[ALCoreDataManager sharedInstance] threadDependentManagedObjectContext];
    
    Board *boardToAdd = (Board *)[context objectWithID:self.board.objectID];
    NSArray *lanes = [[boardToAdd.lanes allObjects] filteredArrayUsingPredicate:[NSPredicate predicateWithFormat:@"title == 'Back Log'"]];
    if([lanes count] > 0)
    {
        Lane *lane = [lanes firstObject];
        
        Task *task = [[self class] getOrCreateTaskWithTitle:self.titleField.text forLane:lane inContext:context];
        task.estimate = [NSNumber numberWithDouble:[self.titleField.text doubleValue]];
    }
    
    NSError *error = nil;
    [context save:&error];
    
    
    [self dismissViewControllerAnimated:YES completion:nil];
}

-(IBAction)dismissButtonPressed:(id)sender
{
    [self dismissViewControllerAnimated:YES completion:nil];
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
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
        task.owner = lane.board.user;
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
