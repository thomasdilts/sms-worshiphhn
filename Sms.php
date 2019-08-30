<?php
namespace thomasdilts\sms_worshiphhn; 
/**
 * This class is the super-class for all SMS implementations for the project thomasdilts/worshiphhn.
 */
abstract class Sms
{
	/**
	 * Using this constant in getImplementationLevel means your code will be able to return a unique identifier for a sent SMS. 
	 * This unique identifier can then be used to make later requests for SMS status.
	 */
	public const IMPLEMENTED_ID_AND_STATUS=1;
	
	/**
	 * Using this constant in getImplementationLevel means your code can receive SMS messages.
	 * This probably should not be used by your code. Not used yet by worshiphhn
	 */
	public const IMPLEMENTED_RECEIVE_SMS=2; // 
	
	/**
	 * @return integer Bitwise AND of the implementation constants, for instance, (IMPLEMENTED_ID_AND_STATUS & IMPLEMENTED_RECEIVE_SMS). 
	 *     Returning zero means that only sending of an SMS is implemented. No statuses or IDs are implemented.
	 */
	abstract public function getImplementationLevel();
	
	/**
	 * @param string $message The message to send.
	 * @param string $phoneNumber A telephone number to send to. The number may not include anything but numbers and must start with the country code number(s).
	 * @return array The array must contain the keys 'id', 'statusId', 'statusText'  
	 *      where 'id' is the ID of the sent SMS which is used for later getting status. This can be blank or zero if not implemented.
	 *            'statusId' is some very short and usually integer that shows the status. This can be blank.
	 *            'statusText' a text explaining the 'statusId'. This can be blank.
	 */
	abstract public function sendSms($message,$phoneNumbers);
	
	/**
	 * This will only be called if getImplementationLevel returns IMPLEMENTED_ID_AND_STATUS.
	 * The last status is sent as an arguement so that your code can see if the last received status is a 'final' status and
	 * therefore your code will not need to get any further status. In that case your code should only return the same statusId and statusText
	 * that is received in the arguements to the function, indicating 'no change'.
	 *
	 * @param string $smsId The ID of the sms to get the status of.
	 * @param string $smsLastStatusId The last statusId received.
	 * @param array $smsLastStatusText The last statusText received.
	 * @return array The array must contain the keys 'statusId', 'statusText'  
	 *      where 'statusId' is some very short and usually integer that shows the status. This can be blank.
	 *            'statusText' a text explaining the 'statusId'. This can be blank.
	 */
	abstract public function getSmsStatus($smsId,$smsLastStatusId,$smsLastStatusText);
	 
	/**
	 * This is only for the future. Do not implement yet. Just put an empty function for this in your sub-class.
	 * In the future, this will only be called if getImplementationLevel returns IMPLEMENTED_RECEIVE_SMS.
	 *
	 * @return array The array must contain a list of arrays that have the keys 'telenumber', 'message'.
	 *      where 'telenumber' is a telephone number that was previously used in a sendSms call.
	 *            'message' The text message received from the previous 'telenumber'.
	 */
	abstract public function receivedSms();	
	
}
