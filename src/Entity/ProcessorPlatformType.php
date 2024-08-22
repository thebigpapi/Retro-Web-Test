<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: 'App\Repository\ProcessorPlatformTypeRepository')]
class ProcessorPlatformType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Length(max: 255, maxMessage: 'Name is longer than {{ limit }} characters.')]
    private $name;

    #[ORM\ManyToMany(targetEntity: Motherboard::class, mappedBy: 'processorPlatformTypes')]
    private $motherboards;

    #[ORM\OneToMany(targetEntity: Chip::class, mappedBy: 'family')]
    private $chips;

    #[ORM\ManyToMany(targetEntity: ProcessorPlatformType::class, inversedBy: 'ChildProcessorPlatformType')]
    private $compatibleWith;

    #[ORM\ManyToMany(targetEntity: ProcessorPlatformType::class, mappedBy: 'compatibleWith')]
    private $ChildProcessorPlatformType;

    #[ORM\ManyToMany(targetEntity: CpuSocket::class, mappedBy: 'platforms')]
    private $cpuSockets;

    #[ORM\ManyToMany(targetEntity: InstructionSet::class, inversedBy: 'processorPlatformTypes')]
    protected $instructionSets;

    #[ORM\Column(length: 4096, nullable: true)]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'processorPlatformType', targetEntity: EntityDocumentation::class, orphanRemoval: true, cascade: ['persist'])]
    #[Assert\Valid()]
    private Collection $entityDocumentations;

    #[ORM\ManyToMany(targetEntity: DramType::class, inversedBy: 'processorPlatformTypes')]
    private Collection $dramType;

    #[ORM\Column(type: Types::JSON, options: ['jsonb' => true])]
    private ?array $miscSpecs = [];

    public function __construct()
    {
        $this->motherboards = new ArrayCollection();
        $this->chips = new ArrayCollection();
        $this->compatibleWith = new ArrayCollection();
        $this->ChildProcessorPlatformType = new ArrayCollection();
        $this->cpuSockets = new ArrayCollection();
        $this->instructionSets = new ArrayCollection();
        $this->entityDocumentations = new ArrayCollection();
        $this->dramType = new ArrayCollection();
    }
    public function __toString(): string
    {
        return $this->name;
    }
    public function getId(): ?int
    {
        return $this->id;
    }
    public function getName(): ?string
    {
        return $this->name;
    }
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
    /**
     * @return Collection|Motherboard[]
     */
    public function getMotherboards(): Collection
    {
        return $this->motherboards;
    }
    public function addMotherboards(Motherboard $motherboard): self
    {
        if (!$this->motherboards->contains($motherboard)) {
            $this->motherboards[] = $motherboard;
            $motherboard->addProcessorPlatformType($this);
        }

        return $this;
    }
    public function removeMotherboard(Motherboard $motherboard): self
    {
        if ($this->motherboards->contains($motherboard)) {
            if ($this->motherboards->contains($motherboard)) {
                $this->motherboards->removeElement($motherboard);
            }

            return $this;
        }

        return $this;
    }
    /**
     * @return Collection|InstructionSet[]
     */
    public function getInstructionSets(): Collection
    {
        return $this->instructionSets;
    }
    public function addInstructionSet(InstructionSet $instructionSet): self
    {
        if (!$this->instructionSets->contains($instructionSet)) {
            $this->instructionSets[] = $instructionSet;
            $instructionSet->addPlatform($this);
        }

        return $this;
    }
    public function removeInstructionSet(InstructionSet $instructionSet): self
    {
        if ($this->instructionSets->contains($instructionSet)) {
            $this->instructionSets->removeElement($instructionSet);
            // set the owning side to null (unless already changed)
            if ($instructionSet->getPlatforms() === $this) {
                $instructionSet->removePlatform($this);
            }
        }

        return $this;
    }
    /**
     * @return Collection|Chip[]
     */
    public function getChips(): Collection
    {
        return $this->chips;
    }
    public function addChip(Chip $chip): self
    {
        if (!$this->chips->contains($chip)) {
            $this->chips[] = $chip;
            $chip->setFamily($this);
        }

        return $this;
    }
    public function removeChip(Chip $chip): self
    {
        if ($this->chips->contains($chip)) {
            $this->chips->removeElement($chip);
            // set the owning side to null (unless already changed)
            if ($chip->getFamily() === $this) {
                $chip->setFamily(null);
            }
        }

        return $this;
    }
    /**
     * @return Collection|self[]
     */
    public function getCompatibleWith(): Collection
    {
        return $this->compatibleWith;
    }
    public function addCompatibleWith(self $compatibleWith): self
    {
        if (!$this->compatibleWith->contains($compatibleWith)) {
            $this->compatibleWith[] = $compatibleWith;
        }

        return $this;
    }
    public function removeCompatibleWith(self $compatibleWith): self
    {
        if ($this->compatibleWith->contains($compatibleWith)) {
            $this->compatibleWith->removeElement($compatibleWith);
        }

        return $this;
    }
    /**
     * @return Collection|self[]
     */
    public function getChildProcessorPlatformType(): Collection
    {
        return $this->ChildProcessorPlatformType;
    }
    public function addChildProcessorPlatformType(self $childProcessorPlatformType): self
    {
        if (!$this->ChildProcessorPlatformType->contains($childProcessorPlatformType)) {
            $this->ChildProcessorPlatformType[] = $childProcessorPlatformType;
            $childProcessorPlatformType->addCompatibleWith($this);
        }

        return $this;
    }
    public function removeChildProcessorPlatformType(self $childProcessorPlatformType): self
    {
        if ($this->ChildProcessorPlatformType->contains($childProcessorPlatformType)) {
            $this->ChildProcessorPlatformType->removeElement($childProcessorPlatformType);
            $childProcessorPlatformType->removeCompatibleWith($this);
        }

        return $this;
    }
    /**
     * @return Collection|CpuSocket[]
     */
    public function getCpuSockets(): Collection
    {
        return $this->cpuSockets;
    }
    public function addCpuSocket(CpuSocket $cpuSocket): self
    {
        if (!$this->cpuSockets->contains($cpuSocket)) {
            $this->cpuSockets[] = $cpuSocket;
            $cpuSocket->addPlatform($this);
        }

        return $this;
    }
    public function removeCpuSocket(CpuSocket $cpuSocket): self
    {
        if ($this->cpuSockets->contains($cpuSocket)) {
            $this->cpuSockets->removeElement($cpuSocket);
            $cpuSocket->removePlatform($this);
        }

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, EntityDocumentation>
     */
    public function getEntityDocumentations(): Collection
    {
        return $this->entityDocumentations;
    }

    public function addEntityDocumentation(EntityDocumentation $entityDocumentation): self
    {
        if (!$this->entityDocumentations->contains($entityDocumentation)) {
            $this->entityDocumentations->add($entityDocumentation);
            $entityDocumentation->setProcessorPlatformType($this);
        }

        return $this;
    }

    public function removeEntityDocumentation(EntityDocumentation $entityDocumentation): self
    {
        if ($this->entityDocumentations->removeElement($entityDocumentation)) {
            // set the owning side to null (unless already changed)
            if ($entityDocumentation->getProcessorPlatformType() === $this) {
                $entityDocumentation->setProcessorPlatformType(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, DramType>
     */
    public function getDramType(): Collection
    {
        return $this->dramType;
    }

    public function addDramType(DramType $dramType): self
    {
        if (!$this->dramType->contains($dramType)) {
            $this->dramType->add($dramType);
        }

        return $this;
    }

    public function removeDramType(DramType $dramType): self
    {
        $this->dramType->removeElement($dramType);

        return $this;
    }

    public function getMiscSpecs(): array
    {
        return $this->miscSpecs ?? [];
    }
    public function getMiscSpecsFormatted(): array
    {
        $output = [];
        foreach($this->getMiscSpecs() as $spec){
            $new = str_replace("\"","",json_encode($spec));
            $new = str_replace(":",": ",$new);
            array_push($output, substr($new, 1, -1));
        }
        return $output;
    }
    public function getSimpleMiscSpecs(): array
    {
        $output = [];
        foreach($this->getMiscSpecs() as $key => $value){
            if(!is_array($value))
                $output[$key] = $value;
        }
        return $output;
    }
    public function getTableMiscSpecs(): array
    {
        $output = [];
        foreach($this->getMiscSpecs() as $key => $value){
            if(is_array($value))
                $output[$key] = $value;
        }
        return $this->sortMiscSpecTables($output);
    }
    function sortMiscSpecTables($arrays) {
        $lengths = array_map('count', $arrays);
        arsort($lengths);
        $return = array();
        foreach(array_keys($lengths) as $k)
            $return[$k] = $arrays[$k];
        return $return;
    }

    public function setMiscSpecs(array $miscSpecs): static
    {
        $this->miscSpecs = $miscSpecs;

        return $this;
    }
}
