<?php

namespace GreenHollow\Pantry\Entity\Aggregate;

use Doctrine\ORM\Mapping as ORM;
use GreenHollow\Pantry\Entity\Household;

/**
 * @ORM\Entity(repositoryClass="GreenHollow\Pantry\Repository\Aggregate\HouseholdAggregateRepository")
 * @ORM\HasLifecycleCallbacks
 */
class HouseholdAggregate
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="smallint")
     */
    private $ageAdult;

    /**
     * @ORM\Column(type="smallint")
     */
    private $ageSenior;

    /**
     * @ORM\Column(type="smallint")
     */
    private $ageUnknown;

    /**
     * @ORM\Column(type="smallint")
     */
    private $ageYouth;

    /**
     * @ORM\Column(type="smallint")
     */
    private $genderFemale;

    /**
     * @ORM\Column(type="smallint")
     */
    private $genderMale;

    /**
     * @ORM\Column(type="smallint")
     */
    private $genderUnknown;

    /**
     * @ORM\Column(type="smallint")
     */
    private $raceAfricanAmerican;

    /**
     * @ORM\Column(type="smallint")
     */
    private $raceAsian;

    /**
     * @ORM\Column(type="smallint")
     */
    private $raceCaucasian;

    /**
     * @ORM\Column(type="smallint")
     */
    private $raceLatino;

    /**
     * @ORM\Column(type="smallint")
     */
    private $raceOther;

    /**
     * @ORM\Column(type="smallint")
     */
    private $raceUnknown;

    /**
     * @ORM\OneToOne(targetEntity="GreenHollow\Pantry\Entity\Household", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $household;

    /**
     * Construct with all aggregates at zero.
     */
    public function __construct()
    {
        $this->ageAdult = 0;
        $this->ageSenior = 0;
        $this->ageUnknown = 0;
        $this->ageYouth = 0;
        $this->genderFemale = 0;
        $this->genderMale = 0;
        $this->genderUnknown = 0;
        $this->raceAfricanAmerican = 0;
        $this->raceAsian = 0;
        $this->raceCaucasian = 0;
        $this->raceLatino = 0;
        $this->raceOther = 0;
        $this->raceUnknown = 0;
    }

    /**
     * Normalize any aggregate discrepancies into unknowns.
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function normalize(): void
    {
        // tally the known aggregates by type
        $knownTotals = [
            'age' => $this->ageAdult + $this->ageSenior + $this->ageYouth,
            'gender' => $this->genderFemale + $this->genderMale,
            'race' => $this->raceAfricanAmerican + $this->raceAsian + $this->raceCaucasian + $this->raceLatino + $this->raceOther,
        ];

        // get the highest known aggregate total
        $highCount = 0;
        foreach (['age', 'gender', 'race'] as $type) {
            $highCount = $knownTotals[$type] > $highCount ? $knownTotals[$type] : $highCount;
        }

        // set the unknown aggregate if known aggregate total is less than that
        $this->ageUnknown = $highCount - $knownTotals['age'];
        $this->genderUnknown = $highCount - $knownTotals['gender'];
        $this->raceUnknown = $highCount - $knownTotals['race'];
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAgeAdult(): ?int
    {
        return $this->ageAdult;
    }

    public function setAgeAdult(int $ageAdult): self
    {
        $this->ageAdult = $ageAdult;

        return $this;
    }

    public function getAgeSenior(): ?int
    {
        return $this->ageSenior;
    }

    public function setAgeSenior(int $ageSenior): self
    {
        $this->ageSenior = $ageSenior;

        return $this;
    }

    public function getAgeUnknown(): ?int
    {
        return $this->ageUnknown;
    }

    public function setAgeUnknown(int $ageUnknown): self
    {
        $this->ageUnknown = $ageUnknown;

        return $this;
    }

    public function getAgeYouth(): ?int
    {
        return $this->ageYouth;
    }

    public function setAgeYouth(int $ageYouth): self
    {
        $this->ageYouth = $ageYouth;

        return $this;
    }

    public function getGenderFemale(): ?int
    {
        return $this->genderFemale;
    }

    public function setGenderFemale(int $genderFemale): self
    {
        $this->genderFemale = $genderFemale;

        return $this;
    }

    public function getGenderMale(): ?int
    {
        return $this->genderMale;
    }

    public function setGenderMale(int $genderMale): self
    {
        $this->genderMale = $genderMale;

        return $this;
    }

    public function getGenderUnknown(): ?int
    {
        return $this->genderUnknown;
    }

    public function setGenderUnknown(int $genderUnknown): self
    {
        $this->genderUnknown = $genderUnknown;

        return $this;
    }

    public function getRaceAfricanAmerican(): ?int
    {
        return $this->raceAfricanAmerican;
    }

    public function setRaceAfricanAmerican(int $raceAfricanAmerican): self
    {
        $this->raceAfricanAmerican = $raceAfricanAmerican;

        return $this;
    }

    public function getRaceAsian(): ?int
    {
        return $this->raceAsian;
    }

    public function setRaceAsian(int $raceAsian): self
    {
        $this->raceAsian = $raceAsian;

        return $this;
    }

    public function getRaceCaucasian(): ?int
    {
        return $this->raceCaucasian;
    }

    public function setRaceCaucasian(int $raceCaucasian): self
    {
        $this->raceCaucasian = $raceCaucasian;

        return $this;
    }

    public function getRaceLatino(): ?int
    {
        return $this->raceLatino;
    }

    public function setRaceLatino(int $raceLatino): self
    {
        $this->raceLatino = $raceLatino;

        return $this;
    }

    public function getRaceOther(): ?int
    {
        return $this->raceOther;
    }

    public function setRaceOther(int $raceOther): self
    {
        $this->raceOther = $raceOther;

        return $this;
    }

    public function getRaceUnknown(): ?int
    {
        return $this->raceUnknown;
    }

    public function setRaceUnknown(int $raceUnknown): self
    {
        $this->raceUnknown = $raceUnknown;

        return $this;
    }

    public function getHousehold(): ?Household
    {
        return $this->household;
    }

    public function setHousehold(Household $household): self
    {
        $this->household = $household;

        return $this;
    }
}
