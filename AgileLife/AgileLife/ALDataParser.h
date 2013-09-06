//
//  ALDataParser.h
//  AgileLife
//
//  Created by Andrew Hyde on 9/5/13.
//  Copyright (c) 2013 Andrew Hyde. All rights reserved.
//

#import <Foundation/Foundation.h>

typedef void (^DataParserBlock)(NSError *error);

@interface ALDataParser : NSObject

+(void)parseDictionary:(NSDictionary *)dictionary withCompletion:(DataParserBlock)completion;

@end
