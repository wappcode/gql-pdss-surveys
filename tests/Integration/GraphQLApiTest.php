<?php

declare(strict_types=1);

namespace Tests\Integration;

use GQLBasicClient\GQLClient;
use GQLBasicClient\GQLClientException;
use PHPUnit\Framework\TestCase;
use RuntimeException;

final class GraphQLApiTest extends TestCase
{
    private const SEED = [
        'surveyId' => 'gqt03d4086ab23209f12247449ec693aa05',
        'targetAudienceId' => 'usm35873f5f3c09e48683b564143d52f18b',
        'questionId' => 'qvcafc7b276826d788ccdf62dd08a5b8344',
        'sectionId' => 'cbr2ba9a868d6bbc3a9daa22703a7e54af4',
        'sectionItemId' => 'twaba6f3a5619989e3d4b0f24fae6d65140',
        'answerSessionId' => 'plib6eb3496130471f547f1ec55ed99127f',
        'answerId' => '1',
        'configurationId' => '1',
        'contentId' => '1',
        'questionOptionId' => '1',
        'username' => 'p.lopez',
        'password' => 'demo',
        'ownerCode' => 'dds20a25cfde285773a34990c9c18ce8539',
    ];

    private static array $created = [];

    private static ?GQLClient $client = null;

    public static function setUpBeforeClass(): void
    {
        $endpoint = getenv('GRAPHQL_ENDPOINT') ?: 'http://127.0.0.1/api';
        self::$client = new GQLClient($endpoint);
    }

    public static function tearDownAfterClass(): void
    {
        if (self::$client === null) {
            return;
        }

        $deleteOrder = [
            'answerId' => 'deleteSurveyAnswer',
            'answerSessionId' => 'deleteSurveyAnswerSession',
            'sectionItemId' => 'deleteSurveySectionItem',
            'questionOptionId' => 'deleteSurveyQuestionOption',
            'questionId' => 'deleteSurveyQuestion',
            'sectionId' => 'deleteSurveySection',
            'contentId' => 'deleteSurveyContent',
            'configurationId' => 'deleteSurveyConfiguration',
            'targetAudienceId' => 'deleteSurveyTargetAudience',
            'surveyId' => 'deleteSurvey',
        ];

        foreach ($deleteOrder as $idKey => $field) {
            $id = self::$created[$idKey] ?? null;
            if (!is_string($id) || $id === '') {
                continue;
            }

            try {
                self::$client->execute(
                    "mutation M(\$id: ID!) { {$field}(id: \$id) }",
                    ['id' => $id]
                );
            } catch (\Throwable $e) {
            }
        }
    }

    public static function operationProviderQueries(): array
    {
        return [
            'getSurveys' => [
                'query Q($input: ConnectionInput) { getSurveys(input: $input) { totalCount } }',
                ['input' => ['pagination' => ['first' => 1]]],
                'getSurveys',
            ],
            'getSurvey' => [
                'query Q($id: ID!) { getSurvey(id: $id) { id } }',
                ['id' => self::SEED['surveyId']],
                'getSurvey',
            ],
            'getSurveyTargetAudiences' => [
                'query Q($input: ConnectionInput) { getSurveyTargetAudiences(input: $input) { totalCount } }',
                ['input' => ['pagination' => ['first' => 1]]],
                'getSurveyTargetAudiences',
            ],
            'getSurveyTargetAudience' => [
                'query Q($id: ID!) { getSurveyTargetAudience(id: $id) { id } }',
                ['id' => self::SEED['targetAudienceId']],
                'getSurveyTargetAudience',
            ],
            'getSurveyAnswers' => [
                'query Q($input: ConnectionInput) { getSurveyAnswers(input: $input) { totalCount } }',
                ['input' => ['pagination' => ['first' => 1]]],
                'getSurveyAnswers',
            ],
            'getSurveyAnswer' => [
                'query Q($id: ID!) { getSurveyAnswer(id: $id) { id } }',
                ['id' => self::SEED['answerId']],
                'getSurveyAnswer',
            ],
            'getSurveyConfigurations' => [
                'query Q($input: ConnectionInput) { getSurveyConfigurations(input: $input) { totalCount } }',
                ['input' => ['pagination' => ['first' => 1]]],
                'getSurveyConfigurations',
            ],
            'getSurveyConfiguration' => [
                'query Q($id: ID!) { getSurveyConfiguration(id: $id) { id } }',
                ['id' => self::SEED['configurationId']],
                'getSurveyConfiguration',
            ],
            'getSurveyContents' => [
                'query Q($input: ConnectionInput) { getSurveyContents(input: $input) { totalCount } }',
                ['input' => ['pagination' => ['first' => 1]]],
                'getSurveyContents',
            ],
            'getSurveyContent' => [
                'query Q($id: ID!) { getSurveyContent(id: $id) { id } }',
                ['id' => self::SEED['contentId']],
                'getSurveyContent',
            ],
            'getSurveyQuestions' => [
                'query Q($input: ConnectionInput) { getSurveyQuestions(input: $input) { totalCount } }',
                ['input' => ['pagination' => ['first' => 1]]],
                'getSurveyQuestions',
            ],
            'getSurveyQuestion' => [
                'query Q($id: ID!) { getSurveyQuestion(id: $id) { id } }',
                ['id' => self::SEED['questionId']],
                'getSurveyQuestion',
            ],
            'getSurveyQuestionOptions' => [
                'query Q($input: ConnectionInput) { getSurveyQuestionOptions(input: $input) { totalCount } }',
                ['input' => ['pagination' => ['first' => 1]]],
                'getSurveyQuestionOptions',
            ],
            'getSurveyQuestionOption' => [
                'query Q($id: ID!) { getSurveyQuestionOption(id: $id) { id } }',
                ['id' => self::SEED['questionOptionId']],
                'getSurveyQuestionOption',
            ],
            'getSurveySections' => [
                'query Q($input: ConnectionInput) { getSurveySections(input: $input) { totalCount } }',
                ['input' => ['pagination' => ['first' => 1]]],
                'getSurveySections',
            ],
            'getSurveySection' => [
                'query Q($id: ID!) { getSurveySection(id: $id) { id } }',
                ['id' => self::SEED['sectionId']],
                'getSurveySection',
            ],
            'getSurveySectionItems' => [
                'query Q($input: ConnectionInput) { getSurveySectionItems(input: $input) { totalCount } }',
                ['input' => ['pagination' => ['first' => 1]]],
                'getSurveySectionItems',
            ],
            'getSurveySectionItem' => [
                'query Q($id: ID!) { getSurveySectionItem(id: $id) { id } }',
                ['id' => self::SEED['sectionItemId']],
                'getSurveySectionItem',
            ],
            'getSurveyAnswerSessions' => [
                'query Q($input: ConnectionInput) { getSurveyAnswerSessions(input: $input) { totalCount } }',
                ['input' => ['pagination' => ['first' => 1]]],
                'getSurveyAnswerSessions',
            ],
            'getSurveyAnswerSession' => [
                'query Q($id: ID!) { getSurveyAnswerSession(id: $id) { id } }',
                ['id' => self::SEED['answerSessionId']],
                'getSurveyAnswerSession',
            ],
            'findSurveyAnswerSessionByUsernameAndPassword' => [
                'query Q($targetAudience: ID!, $username: String!, $password: String!) { findSurveyAnswerSessionByUsernameAndPassword(targetAudience: $targetAudience, username: $username, password: $password) { id } }',
                [
                    'targetAudience' => self::SEED['targetAudienceId'],
                    'username' => self::SEED['username'],
                    'password' => self::SEED['password'],
                ],
                'findSurveyAnswerSessionByUsernameAndPassword',
            ],
            'findSurveyAnswerSessionByOwnerCode' => [
                'query Q($targetAudience: ID!, $ownerCode: String!) { findSurveyAnswerSessionByOwnerCode(targetAudience: $targetAudience, ownerCode: $ownerCode) { id } }',
                [
                    'targetAudience' => self::SEED['targetAudienceId'],
                    'ownerCode' => self::SEED['ownerCode'],
                ],
                'findSurveyAnswerSessionByOwnerCode',
            ],
        ];
    }

    /**
     * @dataProvider operationProviderQueries
     */
    public function test_queries_basic(string $query, array $variables, string $field): void
    {
        $data = $this->execute($query, $variables);
        self::assertArrayHasKey($field, $data, "Query {$field} did not return expected key");
    }

    public function test_mutations_basic_flow(): void
    {
        $suffix = substr(bin2hex(random_bytes(6)), 0, 12);
        $surveyTitle = 'PHPUnit Survey ' . $suffix;

        $createSurvey = $this->execute(
            'mutation M($input: SurveyInput!) { createSurvey(input: $input) { id title } }',
            ['input' => ['title' => $surveyTitle, 'active' => false]]
        );
        self::$created['surveyId'] = $createSurvey['createSurvey']['id'];
        self::assertNotEmpty(self::$created['surveyId']);

        $this->execute(
            'mutation M($id: ID!, $input: SurveyPartialInput!) { updateSurvey(id: $id, input: $input) { id active } }',
            ['id' => self::$created['surveyId'], 'input' => ['active' => true]]
        );

        $createConfiguration = $this->execute(
            'mutation M($input: SurveyConfigurationInput!) { createSurveyConfiguration(input: $input) { id } }',
            ['input' => ['value' => ['className' => 'phpunit'], 'type' => 'PRESENTATION']]
        );
        self::$created['configurationId'] = $createConfiguration['createSurveyConfiguration']['id'];

        $this->execute(
            'mutation M($id: ID!, $input: SurveyConfigurationPartialInput!) { updateSurveyConfiguration(id: $id, input: $input) { id } }',
            ['id' => self::$created['configurationId'], 'input' => ['value' => ['className' => 'phpunit-updated']]]
        );

        $createContent = $this->execute(
            'mutation M($input: SurveyContentInput!) { createSurveyContent(input: $input) { id } }',
            ['input' => ['type' => 'HTML', 'body' => '<p>phpunit</p>']]
        );
        self::$created['contentId'] = $createContent['createSurveyContent']['id'];

        $this->execute(
            'mutation M($id: ID!, $input: SurveyContentPartialInput!) { updateSurveyContent(id: $id, input: $input) { id } }',
            ['id' => self::$created['contentId'], 'input' => ['body' => '<p>phpunit-updated</p>']]
        );

        self::assertTrue($this->deleteById('deleteSurveyContent', self::$created['contentId']));
        self::assertTrue($this->deleteById('deleteSurveyConfiguration', self::$created['configurationId']));
        self::assertTrue($this->deleteById('deleteSurvey', self::$created['surveyId']));
    }

    private function execute(string $query, array $variables = []): array
    {
        self::assertNotNull(self::$client);

        try {
            $result = self::$client->execute($query, $variables);
            $data = $result['data'] ?? null;
            self::assertIsArray($data);

            return $data;
        } catch (GQLClientException $e) {
            $context = $e->getContext();
            self::fail('GraphQL returned errors: ' . $e->getMessage() . ' | context: ' . json_encode($context));
        }

        throw new RuntimeException('Unexpected GraphQL execution path.');
    }

    private function deleteById(string $field, string $id): bool
    {
        $data = $this->execute(
            "mutation M(\$id: ID!) { {$field}(id: \$id) }",
            ['id' => $id]
        );

        return (bool)($data[$field] ?? false);
    }
}
