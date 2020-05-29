use roby;

/*create view pplwithcountrieswithusrtype AS SELECT * FROM ppl left JOIN countries ON ppl.Nationality = countries.COUNTRY_ID;*/
create view pplcountriesadmin as 
SELECT * FROM ppl 
inner JOIN countries 
left JOIN user_roles 
ON ppl.PERSON_ID=countries.COUNTRY_ID=user_roles.ID;