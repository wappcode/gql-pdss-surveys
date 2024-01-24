INSERT INTO `gpd_survey` 
(id, title, active, created, updated)
VALUES ('gqt03d4086ab23209f12247449ec693aa05','Survey 1',1,'2023-12-28 18:40:32','2023-12-28 18:40:32');

INSERT INTO gpd_survey_configuration
(id, config_value, config_type, created, updated)
VALUES (1,'{\"className\": \"section-content-title\"}','PRESENTATION','2023-12-28 18:40:32','2023-12-28 18:40:32'),(2,'{\"className\": \"section-title\"}','PRESENTATION','2023-12-28 18:40:32','2023-12-28 18:40:32'),(3,'{\"className\": \"question-radio-a\"}','PRESENTATION','2023-12-28 18:40:32','2023-12-28 18:40:32'),(4,'[{\"type\": \"regexp\", \"value\": \"[a-zA-Z]\"}]','VALIDATOR','2023-12-28 18:40:32','2023-12-28 18:40:32'),(5,'[{\"anser\": \"o1\", \"score\": 1}, {\"anser\": \"o2\", \"score\": 2}]','ANSWER_SCORE','2023-12-28 18:40:32','2023-12-28 18:40:32'),(6,'{\"className\": \"question-option\"}','PRESENTATION','2023-12-28 18:40:32','2023-12-28 18:40:32'),(7,'{\"className\": \"question-option\"}','PRESENTATION','2023-12-28 18:40:32','2023-12-28 18:40:32');

INSERT INTO gpd_survey_content
(id, presentation_id, config_type, body, created, updated)
VALUES (1,NULL,'HTML','<h1>Audience welcome content</h1>','2023-12-28 18:40:32','2023-12-28 18:40:32'),(2,NULL,'HTML','<h1>Audience farewell content</h1>','2023-12-28 18:40:32','2023-12-28 18:40:32'),(3,1,'HTML','<h1>Hola mundo</h1>','2023-12-28 18:40:32','2023-12-28 18:40:32'),(4,NULL,'HTML','<h2>Section Item</h2>','2023-12-28 18:40:32','2023-12-28 18:40:32'),(5,NULL,'HTML','<h1>Content Question </h1>','2023-12-28 18:40:32','2023-12-28 18:40:32'),(6,NULL,'HTML','<h1>Content option</h1>','2023-12-28 18:40:32','2023-12-28 18:40:32'),(7,NULL,'HTML','<h1>Content option 2</h1>','2023-12-28 18:40:32','2023-12-28 18:40:32');

INSERT INTO gpd_survey_question
(id, content_id, presentation_id, validators_id, answer_score_id, survey_id, title, code, question_type, required, other,question_hint, score, created, updated)
VALUES('qvcafc7b276826d788ccdf62dd08a5b8344',5,3,4,5,'gqt03d4086ab23209f12247449ec693aa05','Question Section 1','Q01','RADIO_LIST',1,0,null,3.0000,'2023-12-28 18:40:32','2023-12-28 18:40:32');

INSERT INTO gpd_survey_question_option
(id, content_id, presentation_id, question_id, option_value, title, order_number, created, updated)
VALUES (1,6,6,'qvcafc7b276826d788ccdf62dd08a5b8344','\"o1\"','Option 1',1,'2023-12-28 18:40:32','2023-12-28 18:40:32'),(2,7,7,'qvcafc7b276826d788ccdf62dd08a5b8344','\"o2\"','Option 2',1,'2023-12-28 18:40:32','2023-12-28 18:40:32');

INSERT INTO gpd_survey_section
(id, content_id, presentation_id, survey_id, title, order_number, hidden, created, updated)
VALUES ('cbr2ba9a868d6bbc3a9daa22703a7e54af4',3,2,'gqt03d4086ab23209f12247449ec693aa05','Section 1',1,0,'2023-12-28 18:40:32','2023-12-28 18:40:32');

INSERT INTO gpd_survey_section_item
(id, condition_id, question_id, content_id, section_id, item_type, order_number, hidden, created, updated)
VALUES ('brb95af5deb6e8ce2c53e43d94f46dd719e',NULL,NULL,4,'cbr2ba9a868d6bbc3a9daa22703a7e54af4','CONTENT',1,0,'2023-12-28 18:40:32','2023-12-28 18:40:32'),
('twaba6f3a5619989e3d4b0f24fae6d65140',NULL,'qvcafc7b276826d788ccdf62dd08a5b8344',NULL,'cbr2ba9a868d6bbc3a9daa22703a7e54af4','QUESTION',2,0,'2023-12-28 18:40:32','2023-12-28 18:40:32');

INSERT INTO `gpd_survey_target_audience` 
(id, welcome_content_id, farewell_content_id, survey_id, presentation_id, title, starts, ends, attempts, created, updated,audience_password)
VALUES ('usm35873f5f3c09e48683b564143d52f18b',1,2,'gqt03d4086ab23209f12247449ec693aa05',NULL,'Audience','2023-12-28 00:47:47','2024-01-28 00:47:47',NULL,'2023-12-28 18:40:32','2023-12-28 18:40:32',null);

INSERT INTO gpd_survey_answer_session
(id, target_audience_id, survey_id, name, username, session_password, owner_code, score, completed, score_percent, created, updated)
VALUES
('pmie907eeb7a84d9c3cbd9bd7dd34042723', 'usm35873f5f3c09e48683b564143d52f18b', 'gqt03d4086ab23209f12247449ec693aa05', null,null,null, 'dds20a25cfde285773a34990c9c18ce8539', null, 0, null, NOW(), NOW()),
('plib6eb3496130471f547f1ec55ed99127f', 'usm35873f5f3c09e48683b564143d52f18b', 'gqt03d4086ab23209f12247449ec693aa05', "pancho","p.lopez","demo", 'irh4cf96cbcb0e54d9aa7e4473da4e94374', null, 0, null, NOW(), NOW()),
('rzmef18da8646350569045dbaa886ba4f17', 'usm35873f5f3c09e48683b564143d52f18b', 'gqt03d4086ab23209f12247449ec693aa05', "","","", 'zlh3eba28fc014bfd4a86cc00b2ed492a3b', null, 0, null, NOW(), NOW());

INSERT INTO gpd_survey_answer
(id, question_id, session_id, answer_value, score, score_percent, created, updated)
VALUES(1, 'qvcafc7b276826d788ccdf62dd08a5b8344', 'pmie907eeb7a84d9c3cbd9bd7dd34042723', "respuesta", null, null, NOW(), NOW());