select Id as Migration_Key, ID_Type__c, ID_No__c, Name,
BillingStreetAddress, BillingPostalCode, IFNULL(BillingCountry,'Singapore'),
Email__c, 
Phone,
DataSource, 
 
IF (ID_Type__c = 'UEN', '012O00000000syjIAA','012O00000000syyIAA') as RecordTypeId,
CASE 
WHEN NumberOfDonationAll = 0 then null
when NumberOfDonationAll = 1 then 'New Donor'
when NumberOfDonationAll = 2 then 'Repeat Donor'
when NumberOfDonationAll > 2 then 'Loyal Donor'
end as DonorStatus,
IFNULL((select Date_Received__c FROM migration_ipc where accountid = a.id Order by Date_received__c desc LIMIT 1),
 (select Donation_date__c FROM migration_cms where accountid = a.id  Order by Donation_Date__c desc LIMIT 1)) as LastDonationDate,
SerialNumberRef from migration_account a LIMIT 50000;




select concat('dipc_', LPAD(a.id, 8, '0')) as MigrationKey,
Payment_Method__c,
Date_received__c,
Date_received__c as ClearedDate,
Transaction_No__c,
Amount__c, 
Old_serial_Number__c,
Dedication__c,
Remarks,
'--None--' as Bank, 
a.AccountId,
a.ContactId,
'Cleared' as Status,
b.SalesforceId as SfAccountId,
c.SalesforceId as SfContactId
 from migration_ipc  a inner join migration_account b 
 on a.accountid = b.id
 left join migration_contact c
 on a.contactid = c.id
 order by a.id LIMIT 100000;


 select a.id, c.salesforceid as ContactSfId, b.salesforceid as AccountSfId from migration_cms a 
inner join migration_account b on a.accountid = b.id
left join migration_contact c on a.contactid = c.id
where a.salesforceid is  null
LIMIT 15000