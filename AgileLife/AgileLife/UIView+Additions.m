//
//  UIView+SubviewHunting.m
//  LargeTableGrip
//
//  Created by Tom Parry on 21/08/13.
//
//

#import "UIView+Additions.h"

@implementation UIView (Additions)

- (UIView* )subviewWithClassName:(NSString*) className
{
	if([[[self class] description] isEqualToString:className])
		return self;
	
	for(UIView* subview in self.subviews)
	{
		UIView* huntedSubview = [subview subviewWithClassName:className];
		
		if(huntedSubview != nil)
			return huntedSubview;
	}
	
	return nil;
}

@end
