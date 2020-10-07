The purpose of this project is being able to save and fetch the information of a blog post with its author. Let's follow the next conceptual
 model to model the domain:  
   
![conceptual model](conceptual_model.png?raw=true "Conceptual Model") 

There will be two endpoints to POST information and one endpoint to GET information:
* [POST] /author to save the author info 
* [POST] /post to save the post info
* [GET] /post/{id} to fetch the post info

The project has being coded using Hexagonal Architecture, CQRS pattern and Event Sourcing. The framework used to build the blogging project is Symfony.  
 
  
The framework used to implement Event Sourcing is [Broadway](https://github.com/broadway).


#Setup
1. Clone this repository
2. Add the next line `127.0.0.1 www.blogging.test blogging.test` to the end of your `/etc/hosts` file.
3. At the root of the project execute `docker-compose up -d`
4. Install project requirements. Run `docker exec -it project-blogging-php composer install`.
5. Create the Event Store schema. Run `docker exec -it project-blogging-php bin/console broadway:event-store:create`

#Usage
1. Let's create the author index in ElasticSearch. Run `curl --location --request PUT 'localhost:9200/authorreadmodel?pretty'`
2. Let's create the post index in ElasticSearch. Run `curl --location --request PUT 'localhost:9200/postreadmodel?pretty'`
3. Next let's insert an Author and a Post. They can be inserted using JSON or XML format. The format is specified in the `Content-Type` of the header. 
4. To insert an Author using JSON format. Run  
`curl --location --request POST 'http://blogging.test/author' \
--header 'Content-Type: application/json' \
--data-raw '{"id":"ee6b7567-a76b-4f7e-9c94-9e620ec96798","name":"Name","surname":"Surname"}'`
5. To insert a Post using XML format. Run   
`curl --location --request POST 'http://blogging.test/post' \
       --header 'Content-Type: application/xml' \
       --data-raw '<?xml version="1.0" encoding="UTF-8" ?>
       <root>
         <id>44d5b99d-d26f-433f-bdbf-9bd808e95499</id>
         <title>Title</title>
         <description>Description</description>
         <content>Content</content>
         <authorId>ee6b7567-a76b-4f7e-9c94-9e620ec96798</authorId>
       </root>'`
6. Let's fetch the post info by its id. The format, JSON or XML, can be specified in the `Content-Type` of the header. 
The GET parameter `includeAuthor=true` includes the author information in the request.  
`curl --location --request GET 'http://blogging.test/post/44d5b99d-d26f-433f-bdbf-9bd808e95499?includeAuthor=true' \
 --header 'Content-Type: application/xml'`
 
 #ElasticSearch
 * Delete author index `curl --location --request DELETE 'localhost:9200/authorreadmodel'`
 * Delete post index `curl --location --request DELETE 'localhost:9200/postreadmodel'`
 * Fetch post index content `curl --location --request GET 'localhost:9200/postreadmodel/_search'`
 * Fetch author index content `curl --location --request GET 'localhost:9200/authorreadmodel/_search'`
 
 #Testing
 * Tu run the test run `docker exec -it project-blogging-php bin/phpunit --testdox`
