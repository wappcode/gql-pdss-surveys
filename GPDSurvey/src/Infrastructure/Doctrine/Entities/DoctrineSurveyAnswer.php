<?php

namespace GPDSurvey\Infrastructure\Doctrine\Entities;

use Doctrine\ORM\Mapping as ORM;
use PDSSUtilities\AbstractEntityModel;

#[ORM\Entity]
#[ORM\Table(
    name: 'gpd_survey_answer',
    indexes: [
        new ORM\Index(name: 'user_created_idx', columns: ['created']),
        new ORM\Index(name: 'user_updated_idx', columns: ['updated']),
    ],
    uniqueConstraints: [
        new ORM\UniqueConstraint(name: 'answer_session_question', columns: ['session_id', 'question_id']),
    ]
)]
class DoctrineSurveyAnswer extends AbstractEntityModel
{


    #[ORM\Column(type: 'text', name: 'answer_value', nullable: true)]
    private ?string $value = null;

    #[ORM\ManyToOne(targetEntity: DoctrineSurveyQuestion::class)]
    #[ORM\JoinColumn(name: 'question_id', referencedColumnName: 'id', nullable: false)]
    private ?DoctrineSurveyQuestion $question = null;

    #[ORM\Column(type: 'decimal', name: 'score', precision: 10, scale: 4, nullable: true)]
    private ?float $score = null;

    #[ORM\Column(type: 'decimal', name: 'score_percent', precision: 8, scale: 4, nullable: true)]
    private ?float $scorePercent = null;

    #[ORM\ManyToOne(targetEntity: DoctrineSurveyAnswerSession::class, inversedBy: 'answers')]
    #[ORM\JoinColumn(name: 'session_id', referencedColumnName: 'id', nullable: false)]
    private ?DoctrineSurveyAnswerSession $session = null;

    #[ORM\Column(type: 'datetimetz_immutable', name: 'created', nullable: false)]
    protected \DateTimeImmutable $created;

    #[ORM\Column(type: 'datetimetz_immutable', name: 'updated', nullable: false)]
    protected \DateTimeImmutable $updated;

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(?string $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getQuestion(): ?DoctrineSurveyQuestion
    {
        return $this->question;
    }

    public function setQuestion(?DoctrineSurveyQuestion $question): self
    {
        $this->question = $question;

        return $this;
    }

    public function getScore(): ?float
    {
        return $this->score;
    }

    public function setScore(?float $score): self
    {
        $this->score = $score;

        return $this;
    }

    public function getScorePercent(): ?float
    {
        return $this->scorePercent;
    }

    public function setScorePercent(?float $scorePercent): self
    {
        $this->scorePercent = $scorePercent;

        return $this;
    }

    public function getSession(): ?DoctrineSurveyAnswerSession
    {
        return $this->session;
    }

    public function setSession(?DoctrineSurveyAnswerSession $session): self
    {
        $this->session = $session;

        return $this;
    }
}
