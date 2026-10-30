INSERT INTO `gpd_survey` 
(id, title, active, created, updated)
VALUES ('01HMY4D8T2C8F0M7R5V9Q1N4K6','Survey 1',1,'2023-12-28 18:40:32','2023-12-28 18:40:32');

INSERT INTO gpd_survey_configuration
(id, config_value, config_type, created, updated)
VALUES (1,'{"className": "section-content-title"}','PRESENTATION','2023-12-28 18:40:32','2023-12-28 18:40:32'),(2,'{"className": "section-title"}','PRESENTATION','2023-12-28 18:40:32','2023-12-28 18:40:32'),(3,'{"className": "question-radio-a"}','PRESENTATION','2023-12-28 18:40:32','2023-12-28 18:40:32'),(4,'[{"type": "regexp", "value": "[a-zA-Z]"}]','VALIDATOR','2023-12-28 18:40:32','2023-12-28 18:40:32'),(5,'[{"anser": "o1", "score": 1}, {"anser": "o2", "score": 2}]','ANSWER_SCORE','2023-12-28 18:40:32','2023-12-28 18:40:32'),(6,'{"className": "question-option"}','PRESENTATION','2023-12-28 18:40:32','2023-12-28 18:40:32'),(7,'{"className": "question-option"}','PRESENTATION','2023-12-28 18:40:32','2023-12-28 18:40:32');

INSERT INTO gpd_survey_content
(id, presentation_id, config_type, body, created, updated)
VALUES (1,NULL,'HTML','<h1>Audience welcome content</h1>','2023-12-28 18:40:32','2023-12-28 18:40:32'),(2,NULL,'HTML','<h1>Audience farewell content</h1>','2023-12-28 18:40:32','2023-12-28 18:40:32'),(3,1,'HTML','<h1>Hola mundo</h1>','2023-12-28 18:40:32','2023-12-28 18:40:32'),(4,NULL,'HTML','<h2>Section Item</h2>','2023-12-28 18:40:32','2023-12-28 18:40:32'),(5,NULL,'HTML','<h1>Content Question </h1>','2023-12-28 18:40:32','2023-12-28 18:40:32'),(6,NULL,'HTML','<h1>Content option</h1>','2023-12-28 18:40:32','2023-12-28 18:40:32'),(7,NULL,'HTML','<h1>Content option 2</h1>','2023-12-28 18:40:32','2023-12-28 18:40:32');

INSERT INTO gpd_survey_question
(id, content_id, presentation_id, validators_id, answer_score_id, survey_id, title, code, question_type, required, other,question_hint, score, created, updated)
VALUES('01HMY4E0M4R7V9K2P6Q8T3N5W1',5,3,4,5,'01HMY4D8T2C8F0M7R5V9Q1N4K6','Question Section 1','Q01','RADIO_LIST',1,0,null,3.0000,'2023-12-28 18:40:32','2023-12-28 18:40:32');

INSERT INTO gpd_survey_question_option
(id, content_id, presentation_id, question_id, option_value, title, order_number, created, updated)
VALUES (1,6,6,'01HMY4E0M4R7V9K2P6Q8T3N5W1','"o1"','Option 1',1,'2023-12-28 18:40:32','2023-12-28 18:40:32'),(2,7,7,'01HMY4E0M4R7V9K2P6Q8T3N5W1','"o2"','Option 2',1,'2023-12-28 18:40:32','2023-12-28 18:40:32');

INSERT INTO gpd_survey_section
(id, content_id, presentation_id, survey_id, title, order_number, hidden, created, updated)
VALUES ('01HMY4E1Q6V3T8M1R5K7P2N4W8',3,2,'01HMY4D8T2C8F0M7R5V9Q1N4K6','Section 1',1,0,'2023-12-28 18:40:32','2023-12-28 18:40:32');

INSERT INTO gpd_survey_section_item
(id, condition_id, question_id, content_id, section_id, item_type, order_number, hidden, created, updated)
VALUES ('01HMY4E2T8P2R5M9Q4V7K3N6W1',NULL,NULL,4,'01HMY4E1Q6V3T8M1R5K7P2N4W8','CONTENT',1,0,'2023-12-28 18:40:32','2023-12-28 18:40:32'),
('01HMY4E3V6P9Q3M8T1R5K7N4W2',NULL,'01HMY4E0M4R7V9K2P6Q8T3N5W1',NULL,'01HMY4E1Q6V3T8M1R5K7P2N4W8','QUESTION',2,0,'2023-12-28 18:40:32','2023-12-28 18:40:32');

INSERT INTO `gpd_survey_target_audience` 
(id, welcome_content_id, farewell_content_id, survey_id, presentation_id, title, starts, ends, attempts, created, updated,audience_password)
VALUES ('01HMY4E4Q7T1M4R9V6K2P8N5W3',1,2,'01HMY4D8T2C8F0M7R5V9Q1N4K6',NULL,'Audience','2023-12-28 00:47:47','2024-01-28 00:47:47',NULL,'2023-12-28 18:40:32','2023-12-28 18:40:32',null);

INSERT INTO gpd_survey_answer_session
(id, target_audience_id, survey_id, name, username, session_password, owner_code, score, completed, score_percent, created, updated)
VALUES
('01HMY4E5V9M2Q6R5T8K1P7N3W4', '01HMY4E4Q7T1M4R9V6K2P8N5W3', '01HMY4D8T2C8F0M7R5V9Q1N4K6', null,null,null, 'dds20a25cfde285773a34990c9c18ce8539', null, 0, null, NOW(), NOW()),
('01HMY4E6R4T8M1Q7V3K6P9N2W5', '01HMY4E4Q7T1M4R9V6K2P8N5W3', '01HMY4D8T2C8F0M7R5V9Q1N4K6', "pancho","p.lopez","demo", 'irh4cf96cbcb0e54d9aa7e4473da4e94374', null, 0, null, NOW(), NOW()),
('01HMY4E7K3Q7V9M2R5T8P1N4W6', '01HMY4E4Q7T1M4R9V6K2P8N5W3', '01HMY4D8T2C8F0M7R5V9Q1N4K6', "","","", 'zlh3eba28fc014bfd4a86cc00b2ed492a3b', null, 0, null, NOW(), NOW());

INSERT INTO gpd_survey_answer
(id, question_id, session_id, answer_value, score, score_percent, created, updated)
VALUES(1, '01HMY4E0M4R7V9K2P6Q8T3N5W1', '01HMY4E5V9M2Q6R5T8K1P7N3W4', "respuesta", null, null, NOW(), NOW());