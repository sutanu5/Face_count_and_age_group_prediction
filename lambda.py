from __future__ import print_function

import boto3
from decimal import Decimal
import json
import urllib

print('Loading function')

rekognition = boto3.client('rekognition')
client = boto3.client('sns')


# --------------- Helper Functions to call Rekognition APIs ------------------




def detect_labels(bucket, key):
    response = rekognition.detect_labels(Image={"S3Object": {"Bucket": bucket, "Name": key}})
    
    # Sample code to write response to DynamoDB table 'MyTable' with 'PK' as Primary Key.
    # Note: role used for executing this Lambda function should have write access to the table.
    #table = boto3.resource('dynamodb').Table('MyTable')
    #labels = [{'Confidence': Decimal(str(label_prediction['Confidence'])), 'Name': label_prediction['Name']} for label_prediction in response['Labels']]
    #table.put_item(Item={'PK': key, 'Labels': labels})
    return response




# --------------- Main handler ------------------


def lambda_handler(event, context):
    '''Demonstrates S3 trigger that uses
    Rekognition APIs to detect faces, labels and index faces in S3 Object.
    '''
    #print("Received event: " + json.dumps(event, indent=2))

    # Get the object from the event
    bucket = event['Records'][0]['s3']['bucket']['name']
    key = urllib.unquote_plus(event['Records'][0]['s3']['object']['key'].encode('utf8'))
    try:
        

        # Calls rekognition DetectLabels API to detect labels in S3 object
        response = detect_labels(bucket, key)
        tosend="";
        for Label in response["Labels"]:
            # print (Label["Name&quot"] + Label["Confidence"])
            #print ('{0} - {1}%'.format(Label["Name"], Label["Confidence"]))
            if(Label["Confidence"]>70):
                tosend+= '{0} - {1}'.format(Label["Name"], Label["Confidence"])+"\n"
                
             
        
        print(response)
        count=0;
        response2 = rekognition.detect_faces(Image={'S3Object':{'Bucket':bucket,'Name':key}},Attributes=['ALL'])
        for faceDetail in response2['FaceDetails']:
            hold=('The detected face is between ' + str(faceDetail['AgeRange']['Low']) 
                  + ' and ' + str(faceDetail['AgeRange']['High']) + ' years old')
            tosend+="\n"+str(hold)
            count=count+1 
            
        tosend+="\ncount = "+str(count)
        translate = boto3.client(service_name='translate', region_name='us-east-2', use_ssl=True)
        result = translate.translate_text(Text=tosend, 
                    SourceLanguageCode="en", TargetLanguageCode="fr")
        print('TranslatedText: ' + result.get('TranslatedText'))
        print('SourceLanguageCode: ' + result.get('SourceLanguageCode'))
        print('TargetLanguageCode: ' + result.get('TargetLanguageCode'))
        tosend+="\n"
        tosend+=result.get('TranslatedText')
        massage = client.publish(TargetArn='arn:aws:sns:us-east-2:112674153809:image-processing-chakra',Message=tosend,Subject='Number of faces and age group')
        
        # Print response to console.
        return response
    except Exception as e:
        print(e)
        print("Error processing object {} from bucket {}. ".format(key, bucket) +
              "Make sure your object and bucket exist and your bucket is in the same region as this function.")
        raise e
