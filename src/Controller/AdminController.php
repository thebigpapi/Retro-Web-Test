<?php

namespace App\Controller;

use App\Entity\CpuSocket;
use App\Entity\ExpansionCardType;
use App\Entity\IoPortInterface;
use App\Entity\IoPortInterfaceSignal;
use App\Entity\ExpansionSlotInterfaceSignal;
use App\Entity\IoPortSignal;
use App\Entity\LargeFile;
use App\Entity\ProcessorPlatformType;
use App\Repository\CdDriveRepository;
use App\Repository\ChipsetRepository;
use App\Repository\CpuSocketRepository;
use App\Repository\CreditorRepository;
use App\Repository\ExpansionCardRepository;
use App\Repository\ExpansionCardTypeRepository;
use App\Repository\ExpansionChipRepository;
use App\Repository\ExpansionChipTypeRepository;
use App\Repository\FloppyDriveRepository;
use App\Repository\HardDriveRepository;
use App\Repository\IoPortInterfaceRepository;
use App\Repository\IoPortInterfaceSignalRepository;
use App\Repository\ExpansionSlotInterfaceSignalRepository;
use App\Repository\IoPortSignalRepository;
use App\Repository\LargeFileRepository;
use App\Repository\ManufacturerRepository;
use App\Repository\MotherboardRepository;
use App\Repository\OsArchitectureRepository;
use App\Repository\OsFlagRepository;
use App\Repository\ProcessorRepository;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Exception;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

class AdminController extends AbstractDashboardController
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    // admin routes
    #[Route('/admin/updatechipset', name:'update_chipsets_cached_name')]
    public function updateChipsetsCachedName(): Response
    {
        $idx = 1;
        return $this->redirect($this->generateUrl('update_chipsets_cached_name_idx', array("idx" => $idx)));
    }

    #[Route('/admin/updatechipset/{idx}', name:'update_chipsets_cached_name_idx', requirements: ['idx' => '\d+'])]
    public function updateChipsetsCachedNameAB(ChipsetRepository $chipsetRepository, int $idx, EntityManagerInterface $entityManager): Response
    {
        $run = false;
        foreach($chipsetRepository->findAll() as $chip){
            if($chip->getId() >= $idx && $chip->getId() <= ($idx + 100)){
                $chip->updateCachedName();
                $entityManager->persist($chip);
                $entityManager->flush();
                $run = true;
            }
        }
        if($run == false)
            return $this->redirect($this->generateUrl('update_chipsets_cached_name_done'));
        return $this->redirect($this->generateUrl('update_chipsets_cached_name_idx', array("idx" => ($idx + 100))));
    }

    #[Route('/admin/updatechipset/done', name:'update_chipsets_cached_name_done')]
    public function updateChipsetsCachedNameDone(): JsonResponse
    {
        return new JsonResponse("finished");
    }
    // dashboard routes

    #[Route('/dashboard/filterchips', name:'mobo_filter_chips', methods:['POST'])]
    public function filterChips(Request $request, ExpansionChipRepository $expansionChipRepository): JsonResponse
    {
        $chips = json_decode($request->getContent());
        $deletechips = array();
        foreach($chips as $chip){
            $chipEntity = $expansionChipRepository->findById($chip)[0];
            if($chipEntity->getType()->getId() == 30)
                array_push($deletechips, $chip);
        }
        return new JsonResponse($deletechips);
    }

    #[Route('/dashboard/finddriver', name:'find_driver', methods:['GET'])]
    public function findDriver(Request $request, LargeFileRepository $largeFileRepository): JsonResponse
    {
        $criteria['name'] = $request->query->get('name');
        if($request->query->get('version'))
            $criteria['version'] = $request->query->get('version');
        $os = $request->query->get('os');
        if($os != "")
            $criteria["osFlags"] = explode(",", $request->query->get('os'));
        $driver = $largeFileRepository->findByDriver($criteria);
        $list = array();
        foreach($driver as $drv){
            $list[$drv->getNameWithTags()] = $drv->getId();
        }
        return new JsonResponse(array_slice($list, 0, 1));
    }

    #[Route('/dashboard/getallchipsets', name:'mobo_get_all_chipsets', methods:['POST'])]
    public function getAllChipsets(Request $request, ChipsetRepository $chipsetRepository): JsonResponse
    {
        $chipsets = array();
        foreach($chipsetRepository->findAll() as $chipset){
            $chipsets[$chipset->getId()] = $chipset->getNameCached();
        }
        return new JsonResponse($chipsets);
    }

    #[Route('/dashboard/getbiosmanufacturers', name:'get_bios_manufacturers', methods:['GET'])]
    public function getBiosManufacturers(ManufacturerRepository $manufacturerRepository): JsonResponse
    {
        $list = array();
        foreach($manufacturerRepository->findAllBiosManufacturer() as $item){
            $list[$item->getName()] = $item->getId();
        }
        return new JsonResponse($list);
    }

    #[Route('/dashboard/getchips', name:'mobo_get_chips', methods:['POST'])]
    public function getChips(Request $request, ChipsetRepository $chipsetRepository): JsonResponse
    {
        $chipset = json_decode($request->getContent());
        $chips = array();

        foreach($chipsetRepository->findById($chipset)[0]->getExpansionChips() as $chip){
            $chips[$chip->getId()] = $chip->getFullName();
        }
        return new JsonResponse($chips);
    }

    #[Route('/dashboard/getchipsets', name:'mobo_get_chipsets', methods:['POST'])]
    public function getChipsets(Request $request, ChipsetRepository $chipsetRepository): JsonResponse
    {
        $chips = json_decode($request->getContent());
        $chipsets = array();
        foreach($chipsetRepository->findByChips($chips) as $chipset){
            $chipsets[$chipset->getId()] = $chipset->getNameCached();
        }
        return new JsonResponse($chipsets);
    }

    #[Route('/dashboard/getcpufamilies', name:'mobo_get_cpu_families', methods:['POST'])]
    public function getCPUFamilies(Request $request, CpuSocketRepository $cpuSocketRepository): JsonResponse
    {
        $platforms = array();
        $cpuSockets = json_decode($request->getContent());
        if ($cpuSockets[0] instanceof CpuSocket) {
            foreach ($cpuSockets as $socket) {
                $platforms = array_merge($platforms, $socket->getPlatforms()->toArray());
            }
        } else {
            foreach ($cpuSockets as $socketId) {
                $socket = $cpuSocketRepository->find($socketId);
                $platforms = array_merge($platforms, $socket->getPlatforms()->toArray());
            }
        }
        usort($platforms, function (ProcessorPlatformType $a, ProcessorPlatformType $b) {
            return strnatcasecmp($a->getName() ?? '', $b->getName() ?? '');
        });
        $cpuPlatforms = array();
        foreach($platforms as $platform){
            $cpuPlatforms["e" . (string)$platform->getId()] = $platform->getName();
        }
        return new JsonResponse($cpuPlatforms);
    }

    #[Route('/dashboard/getcreditors', name:'get_creditors', methods:['GET'])]
    public function getCreditors(CreditorRepository $creditorRepository): JsonResponse
    {
        $list = array();
        foreach($creditorRepository->findAllCreditors() as $item){
            $list[$item->getId()] = $item->getName();
        }
        return new JsonResponse($list);
    }

    #[Route('/dashboard/getdriverfields', name:'get_driver_fields', methods:['GET'])]
    public function getDriverFields(OsFlagRepository $osFlagRepository, OsArchitectureRepository $osArchitectureRepository, CsrfTokenManagerInterface $csrfTokenManager): JsonResponse
    {
        $listFlags = array();
        $listArchs = array();
        $token = $csrfTokenManager->getToken('ea-action-new')->getValue();
        $osFlags = $osFlagRepository->findAll();
        $osArchs = $osArchitectureRepository->findAll();
        foreach($osFlags as $flag)
            $listFlags[$flag->getName()] = $flag->getId();
        foreach($osArchs as $arch)
            $listArchs[$arch->getName()] = $arch->getId();
        return new JsonResponse([
            $listFlags,
            $listArchs,
            $token
        ]);
    }

    #[Route('/dashboard/getexpansioncardtemplate/', name:'get_expansion_card_template', methods:['GET'])]
    public function getExpansioncardTemplate(Request $request, ExpansionCardTypeRepository $expansionCardTypeRepository): JsonResponse
    {
        $templates = [];
        $filtersJson = $request->query->get('ids');
        $ids = json_decode($filtersJson ?? "", true);
        if (!$ids) {
            throw new Exception("Missing or wrong expansion card type id list");
        }
        $templates = array_map(fn (ExpansionCardType $expansionCardType) => $expansionCardType->getTemplate(), $expansionCardTypeRepository->findBy(['id' => $ids]));
        $templatesMerged = [];

        foreach ($templates as $template) {
            foreach ($template as $key => $value) {
                $templatesMerged[$key] = $value;
            }
        }

        return new JsonResponse($templatesMerged);
    }

    #[Route('/dashboard/getexpansionchiptemplate/{id}', name:'get_expansion_chip_template', methods:['GET'],  requirements: ['id' => '\d+'])]
    public function getExpansionChipTemplate(int $id, ExpansionChipTypeRepository $expansionChipTypeRepository): JsonResponse
    {
        $chipType = $expansionChipTypeRepository->find($id);

        return new JsonResponse($chipType->getTemplate());
    }

    #[Route('/dashboard/getexpansionchipspci', name:'get_expansion_chips_pci_id', methods:['POST'])]
    public function getExpansionChipsPciId(Request $request, ExpansionChipRepository $expansionChipRepository): JsonResponse
    {
        $ids = json_decode($request->getContent());
        //dd($ids);
        if(!$ids)
            return new JsonResponse([]);
        $chips = array();
        foreach($expansionChipRepository->findByPciId($ids) as $chip){
            $chips[$chip->getId()] = $chip->getFullName();
        }
        return new JsonResponse($chips);
    }

    #[Route('/dashboard/getexpslots/{id}', name:'get_expslots', methods:['GET'], requirements: ['id' => '\d+'])]
    public function getExpSlots(Request $request, ExpansionSlotInterfaceSignalRepository $expansionSlotInterfaceSignalRepository, ?int $id = null): JsonResponse
    {
        $expslots = [];
        if ($id) {
            $slot = $expansionSlotInterfaceSignalRepository->find($id);
            if (!$slot) {
                return new Response('', 404);
            }
            $expslots = [$slot];
        } else {
            $filtersJson = $request->query->get('filters');
            if (!$filtersJson) {
                $expslots =$expansionSlotInterfaceSignalRepository->findAll();
            } else {
                $filters = json_decode($filtersJson, true);
                $expslots = $expansionSlotInterfaceSignalRepository->findBy($filters);
            }
        }

        return new JsonResponse(array_map(fn (ExpansionSlotInterfaceSignal $slot) => $slot->jsonSerialize(), $expslots));
    }

    #[Route('/dashboard/getioportinterfaces/{id}', name:'get_ioportinterfaces', methods:['GET'], requirements: ['id' => '\d+'])]
    public function getIoPortInterfaces(IoPortInterfaceRepository $ioPortInterfaceRepository, ?int $id = null): JsonResponse
    {
        $interfaces = [];
        if ($id) {
            $interface = $ioPortInterfaceRepository->find($id);
            if (!$interface) {
                return new Response('', 404);
            }
            $interfaces = [$interface];
        } else {
            $interfaces =$ioPortInterfaceRepository->findAll();
        }

        return new JsonResponse(array_map(fn (IoPortInterface $interface) => $interface->jsonSerialize(), $interfaces));
    }

    #[Route('/dashboard/getioports/{id}', name:'get_ioports', methods:['GET'], requirements: ['id' => '\d+'])]
    public function getIoPorts(Request $request, IoPortInterfaceSignalRepository $ioPortInterfaceSignalRepository, ?int $id = null): JsonResponse
    {
        $ioports = [];
        if ($id) {
            $ioport = $ioPortInterfaceSignalRepository->find($id);
            if (!$ioport) {
                return new Response('', 404);
            }
            $ioports = [$ioport];
        } else {
            $filtersJson = $request->query->get('filters');
            if (!$filtersJson) {
                $ioports =$ioPortInterfaceSignalRepository->findAll();
            } else {
                $filters = json_decode($filtersJson, true);
                $ioports = $ioPortInterfaceSignalRepository->findBy($filters);
            }
        }

        return new JsonResponse(array_map(fn (IoPortInterfaceSignal $ioport) => $ioport->jsonSerialize(), $ioports));
    }

    #[Route('/dashboard/getioportsignals/{id}', name:'get_ioportsignals', methods:['GET'], requirements: ['id' => '\d+'])]
    public function getIoPortSignals(IoPortSignalRepository $ioPortSignalRepository, ?int $id = null): JsonResponse
    {
        $signals = [];
        if ($id) {
            $signal = $ioPortSignalRepository->find($id);
            if (!$signal) {
                return new Response('', 404);
            }
            $signals = [$signal];
        } else {
            $signals =$ioPortSignalRepository->findAll();
        }

        return new JsonResponse(array_map(fn (IoPortSignal $signal) => $signal->jsonSerialize(), $signals));
    }

    #[Route('/dashboard/settings', name:'admin_user_settings')]
    public function userIndex(): Response
    {
        return $this->render('admin/users/index.html.twig');
    }
    #[Route('/dashboard/settings/resetpass/{id}', name: 'admin_reset_pass', requirements: ['id' => '\d+'])]
    public function resetPasswd(int $id, Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager, UserRepository $userRepository): Response
    {
        $user = $userRepository->find($id);
        $password = $this->randomStr(16);
        $hashedPassword = $passwordHasher->hashPassword($user, $password);
        $user->setPassword($hashedPassword);

        $entityManager->persist($user);
        $entityManager->flush();

        return $this->render('admin/users/password_reset.html.twig', [
            'username' => $user->getUsername(),
            'password' => $password,
        ]);
    }

    /**
     * @param int $length      How many characters do we want?
     * @param string $keyspace A string of all possible characters
     *                         to select from
     * @return string
     */
    private function randomStr(int $length, string $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'): string
    {
        $str = '';
        $max = mb_strlen($keyspace, '8bit') - 1;
        if ($max < 1) {
            throw new \Exception('$keyspace must be at least two characters long');
        }
        for ($i = 0; $i < $length; ++$i) {
            $str .= $keyspace[random_int(0, $max)];
        }
        return $str;
    }

    #[Route('/dashboard/settings/password', name:'admin_user_changepwd')]
    public function changeUserPassword(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager, UserRepository $userRepository): Response
    {
        $form = $this->createFormBuilder()
            ->add('old_password', PasswordType::class)
            ->add('new_password', PasswordType::class)
            ->add('new_password_confirm', PasswordType::class)
            ->add('save', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $user = $userRepository->findOneBy(["username" => $this->getUser()->getUserIdentifier()]);

            $checkPass = $passwordHasher->isPasswordValid($user, $data['old_password']);
            if ($checkPass === true) {
                if ($data['new_password'] === $data['new_password_confirm']) {
                    $hashedPassword = $passwordHasher->hashPassword($user, $data['new_password_confirm']);
                    $user->setPassword($hashedPassword);
                    $entityManager->persist($user);
                    $entityManager->flush();
                    return $this->render('admin/users/message.html.twig', [
                        'message' => 'Password updated successfully !',
                        'path' => 'admin_user_settings',
                    ]);
                } else {
                    return $this->render('admin/users/message.html.twig', [
                        'message' => 'New password fields do not match! Try again.',
                        'path' => 'admin_user_changepwd',
                    ]);
                }
            } else {
                return $this->render('admin/users/message.html.twig', [
                    'message' => 'Current password does not match! Try again.',
                    'path' => 'admin_user_changepwd',
                ]);
            }
        }
        return $this->render('admin/users/change_pass.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/dashboard/settings/username', name:'admin_user_changename')]
    public function changeUserName(Request $request, EntityManagerInterface $entityManager, UserRepository $userRepository): Response
    {
        $form = $this->createFormBuilder()
            ->add('new_username', TextType::class)
            ->add('save', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $user = $userRepository->findOneBy(["username" => $this->getUser()->getUserIdentifier()]);
            if (strlen($data['new_username']) > 1 && strlen($data['new_username']) < 51) {
                if ($data['new_username'] === $user->getUsername()) {
                    return $this->render('admin/users/message.html.twig', [
                        'message' => 'Username is identical! Try again.',
                        'path' => 'admin_user_changename',
                    ]);
                } else {
                    $user->setUsername($data['new_username']);
                    $entityManager->persist($user);
                    $entityManager->flush();
                    return $this->render('admin/users/message.html.twig', [
                        'message' => 'Username updated successfully !',
                        'path' => 'admin_user_settings',
                    ]);
                }
            } else {
                return $this->render('admin/users/message.html.twig', [
                    'message' => 'Username is invalid! Try again.',
                    'path' => 'admin_user_changename',
                ]);
            }
        }
        return $this->render('admin/users/change_name.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/dashboard/creditorimages/boards/{id}/{name}', name:'dashboard_creditor_images_boards', requirements: ['id' => '\d+'])]
    public function creditorImagesBoards(
        int $id,
        string $name,
        MotherboardRepository $motherboardRepository,
        PaginatorInterface $paginatorInterface,
        AdminUrlGenerator $adminUrlGenerator,
        Request $request
    ): Response
    {
        $board_data = $motherboardRepository->findAllByCreditor($id);
        $boards = $paginatorInterface->paginate($board_data, $request->query->getInt('page', 1), 50);
        $targetUrlCards = $adminUrlGenerator
            ->setController(self::class)
            ->setRoute('dashboard_creditor_images_cards', ['id' => $id, 'name' => $name])
            ->setEntityId($id)
            ->generateUrl();
        $targetUrlChips = $adminUrlGenerator
            ->setController(self::class)
            ->setRoute('dashboard_creditor_images_chips', ['id' => $id, 'name' => $name])
            ->setEntityId($id)
            ->generateUrl();
        $targetUrlCpus = $adminUrlGenerator
            ->setController(self::class)
            ->setRoute('dashboard_creditor_images_cpus', ['id' => $id, 'name' => $name])
            ->setEntityId($id)
            ->generateUrl();
        $targetUrlHdds = $adminUrlGenerator
            ->setController(self::class)
            ->setRoute('dashboard_creditor_images_hdds', ['id' => $id, 'name' => $name])
            ->setEntityId($id)
            ->generateUrl();
        $targetUrlCdds = $adminUrlGenerator
            ->setController(self::class)
            ->setRoute('dashboard_creditor_images_cdds', ['id' => $id, 'name' => $name])
            ->setEntityId($id)
            ->generateUrl();
        $targetUrlFdds = $adminUrlGenerator
            ->setController(self::class)
            ->setRoute('dashboard_creditor_images_fdds', ['id' => $id, 'name' => $name])
            ->setEntityId($id)
            ->generateUrl();
        return $this->render('admin/creditor/boards.html.twig', [
            'motherboards' => $boards,
            'urlCards' => $targetUrlCards,
            'urlChips' => $targetUrlChips,
            'urlCpus' => $targetUrlCpus,
            'urlHdds' => $targetUrlHdds,
            'urlCdds' => $targetUrlCdds,
            'urlFdds' => $targetUrlFdds,
            'name' => $name,
        ]);
    }
    #[Route('/dashboard/creditorimages/cards/{id}/{name}', name:'dashboard_creditor_images_cards', requirements: ['id' => '\d+'])]
    public function creditorImagesCards(
        int $id,
        string $name,
        ExpansionCardRepository $expansionCardRepository,
        PaginatorInterface $paginatorInterface,
        AdminUrlGenerator $adminUrlGenerator,
        Request $request
    ): Response
    {
        $card_data = $expansionCardRepository->findAllByCreditor($id);
        $cards =  $paginatorInterface->paginate($card_data, $request->query->getInt('page', 1), 50);
        $targetUrlBoards = $adminUrlGenerator
            ->setController(self::class)
            ->setRoute('dashboard_creditor_images_boards', ['id' => $id, 'name' => $name])
            ->setEntityId($id)
            ->generateUrl();
        $targetUrlChips = $adminUrlGenerator
            ->setController(self::class)
            ->setRoute('dashboard_creditor_images_chips', ['id' => $id, 'name' => $name])
            ->setEntityId($id)
            ->generateUrl();
        $targetUrlCpus = $adminUrlGenerator
            ->setController(self::class)
            ->setRoute('dashboard_creditor_images_cpus', ['id' => $id, 'name' => $name])
            ->setEntityId($id)
            ->generateUrl();
        $targetUrlHdds = $adminUrlGenerator
            ->setController(self::class)
            ->setRoute('dashboard_creditor_images_hdds', ['id' => $id, 'name' => $name])
            ->setEntityId($id)
            ->generateUrl();
        $targetUrlCdds = $adminUrlGenerator
            ->setController(self::class)
            ->setRoute('dashboard_creditor_images_cdds', ['id' => $id, 'name' => $name])
            ->setEntityId($id)
            ->generateUrl();
        $targetUrlFdds = $adminUrlGenerator
            ->setController(self::class)
            ->setRoute('dashboard_creditor_images_fdds', ['id' => $id, 'name' => $name])
            ->setEntityId($id)
            ->generateUrl();
        return $this->render('admin/creditor/cards.html.twig', [
            'cards' => $cards,
            'urlBoards' => $targetUrlBoards,
            'urlChips' => $targetUrlChips,
            'urlCpus' => $targetUrlCpus,
            'urlHdds' => $targetUrlHdds,
            'urlCdds' => $targetUrlCdds,
            'urlFdds' => $targetUrlFdds,
            'name' => $name,
        ]);
    }
    #[Route('/dashboard/creditorimages/chips/{id}/{name}', name:'dashboard_creditor_images_chips', requirements: ['id' => '\d+'])]
    public function creditorImagesChips(
        int $id,
        string $name,
        ExpansionChipRepository $expansionChipRepository,
        PaginatorInterface $paginatorInterface,
        AdminUrlGenerator $adminUrlGenerator,
        Request $request
    ): Response
    {
        $chip_data = $expansionChipRepository->findAllByCreditor($id);
        $chips = $paginatorInterface->paginate($chip_data, $request->query->getInt('page', 1), 50);
        $targetUrlBoards = $adminUrlGenerator
            ->setController(self::class)
            ->setRoute('dashboard_creditor_images_boards', ['id' => $id, 'name' => $name])
            ->setEntityId($id)
            ->generateUrl();
        $targetUrlCards = $adminUrlGenerator
            ->setController(self::class)
            ->setRoute('dashboard_creditor_images_cards', ['id' => $id, 'name' => $name])
            ->setEntityId($id)
            ->generateUrl();
        $targetUrlCpus = $adminUrlGenerator
            ->setController(self::class)
            ->setRoute('dashboard_creditor_images_cpus', ['id' => $id, 'name' => $name])
            ->setEntityId($id)
            ->generateUrl();
        $targetUrlHdds = $adminUrlGenerator
            ->setController(self::class)
            ->setRoute('dashboard_creditor_images_hdds', ['id' => $id, 'name' => $name])
            ->setEntityId($id)
            ->generateUrl();
        $targetUrlCdds = $adminUrlGenerator
            ->setController(self::class)
            ->setRoute('dashboard_creditor_images_cdds', ['id' => $id, 'name' => $name])
            ->setEntityId($id)
            ->generateUrl();
        $targetUrlFdds = $adminUrlGenerator
            ->setController(self::class)
            ->setRoute('dashboard_creditor_images_fdds', ['id' => $id, 'name' => $name])
            ->setEntityId($id)
            ->generateUrl();
        return $this->render('admin/creditor/chips.html.twig', [
            'chips' => $chips,
            'urlBoards' => $targetUrlBoards,
            'urlCards' => $targetUrlCards,
            'urlCpus' => $targetUrlCpus,
            'urlHdds' => $targetUrlHdds,
            'urlCdds' => $targetUrlCdds,
            'urlFdds' => $targetUrlFdds,
            'name' => $name,
        ]);
    }
    #[Route('/dashboard/creditorimages/cpus/{id}/{name}', name:'dashboard_creditor_images_cpus', requirements: ['id' => '\d+'])]
    public function creditorImagesCpus(
        int $id,
        string $name,
        ProcessorRepository $processorRepository,
        PaginatorInterface $paginatorInterface,
        AdminUrlGenerator $adminUrlGenerator,
        Request $request
    ): Response
    {
        $cpu_data = $processorRepository->findAllByCreditor($id);
        $cpus = $paginatorInterface->paginate($cpu_data, $request->query->getInt('page', 1), 50);
        $targetUrlBoards = $adminUrlGenerator
            ->setController(self::class)
            ->setRoute('dashboard_creditor_images_boards', ['id' => $id, 'name' => $name])
            ->setEntityId($id)
            ->generateUrl();
        $targetUrlCards = $adminUrlGenerator
            ->setController(self::class)
            ->setRoute('dashboard_creditor_images_cards', ['id' => $id, 'name' => $name])
            ->setEntityId($id)
            ->generateUrl();
        $targetUrlChips = $adminUrlGenerator
            ->setController(self::class)
            ->setRoute('dashboard_creditor_images_chips', ['id' => $id, 'name' => $name])
            ->setEntityId($id)
            ->generateUrl();
        $targetUrlHdds = $adminUrlGenerator
            ->setController(self::class)
            ->setRoute('dashboard_creditor_images_hdds', ['id' => $id, 'name' => $name])
            ->setEntityId($id)
            ->generateUrl();
        $targetUrlCdds = $adminUrlGenerator
            ->setController(self::class)
            ->setRoute('dashboard_creditor_images_cdds', ['id' => $id, 'name' => $name])
            ->setEntityId($id)
            ->generateUrl();
        $targetUrlFdds = $adminUrlGenerator
            ->setController(self::class)
            ->setRoute('dashboard_creditor_images_fdds', ['id' => $id, 'name' => $name])
            ->setEntityId($id)
            ->generateUrl();
        return $this->render('admin/creditor/cpus.html.twig', [
            'cpus' => $cpus,
            'urlBoards' => $targetUrlBoards,
            'urlCards' => $targetUrlCards,
            'urlChips' => $targetUrlChips,
            'urlHdds' => $targetUrlHdds,
            'urlCdds' => $targetUrlCdds,
            'urlFdds' => $targetUrlFdds,
            'name' => $name,
        ]);
    }
    #[Route('/dashboard/creditorimages/hdds/{id}/{name}', name:'dashboard_creditor_images_hdds', requirements: ['id' => '\d+'])]
    public function creditorImagesHdds(
        int $id,
        string $name,
        HardDriveRepository $hddRepository,
        PaginatorInterface $paginatorInterface,
        AdminUrlGenerator $adminUrlGenerator,
        Request $request
    ): Response
    {
        $hdd_data = $hddRepository->findAllByCreditor($id);
        $hdds = $paginatorInterface->paginate($hdd_data, $request->query->getInt('page', 1), 50);
        $targetUrlBoards = $adminUrlGenerator
            ->setController(self::class)
            ->setRoute('dashboard_creditor_images_boards', ['id' => $id, 'name' => $name])
            ->setEntityId($id)
            ->generateUrl();
        $targetUrlCards = $adminUrlGenerator
            ->setController(self::class)
            ->setRoute('dashboard_creditor_images_cards', ['id' => $id, 'name' => $name])
            ->setEntityId($id)
            ->generateUrl();
        $targetUrlChips = $adminUrlGenerator
            ->setController(self::class)
            ->setRoute('dashboard_creditor_images_chips', ['id' => $id, 'name' => $name])
            ->setEntityId($id)
            ->generateUrl();
        $targetUrlCpus = $adminUrlGenerator
            ->setController(self::class)
            ->setRoute('dashboard_creditor_images_cpus', ['id' => $id, 'name' => $name])
            ->setEntityId($id)
            ->generateUrl();
        $targetUrlCdds = $adminUrlGenerator
            ->setController(self::class)
            ->setRoute('dashboard_creditor_images_cdds', ['id' => $id, 'name' => $name])
            ->setEntityId($id)
            ->generateUrl();
        $targetUrlFdds = $adminUrlGenerator
            ->setController(self::class)
            ->setRoute('dashboard_creditor_images_fdds', ['id' => $id, 'name' => $name])
            ->setEntityId($id)
            ->generateUrl();
        return $this->render('admin/creditor/hdds.html.twig', [
            'hdds' => $hdds,
            'urlBoards' => $targetUrlBoards,
            'urlCards' => $targetUrlCards,
            'urlChips' => $targetUrlChips,
            'urlCpus' => $targetUrlCpus,
            'urlCdds' => $targetUrlCdds,
            'urlFdds' => $targetUrlFdds,
            'name' => $name,
        ]);
    }
    #[Route('/dashboard/creditorimages/cdds/{id}/{name}', name:'dashboard_creditor_images_cdds', requirements: ['id' => '\d+'])]
    public function creditorImagesCdds(
        int $id,
        string $name,
        CdDriveRepository $cddRepository,
        PaginatorInterface $paginatorInterface,
        AdminUrlGenerator $adminUrlGenerator,
        Request $request
    ): Response
    {
        $cdd_data = $cddRepository->findAllByCreditor($id);
        $cdds = $paginatorInterface->paginate($cdd_data, $request->query->getInt('page', 1), 50);
        $targetUrlBoards = $adminUrlGenerator
            ->setController(self::class)
            ->setRoute('dashboard_creditor_images_boards', ['id' => $id, 'name' => $name])
            ->setEntityId($id)
            ->generateUrl();
        $targetUrlCards = $adminUrlGenerator
            ->setController(self::class)
            ->setRoute('dashboard_creditor_images_cards', ['id' => $id, 'name' => $name])
            ->setEntityId($id)
            ->generateUrl();
        $targetUrlChips = $adminUrlGenerator
            ->setController(self::class)
            ->setRoute('dashboard_creditor_images_chips', ['id' => $id, 'name' => $name])
            ->setEntityId($id)
            ->generateUrl();
        $targetUrlCpus = $adminUrlGenerator
            ->setController(self::class)
            ->setRoute('dashboard_creditor_images_cpus', ['id' => $id, 'name' => $name])
            ->setEntityId($id)
            ->generateUrl();
        $targetUrlHdds = $adminUrlGenerator
            ->setController(self::class)
            ->setRoute('dashboard_creditor_images_hdds', ['id' => $id, 'name' => $name])
            ->setEntityId($id)
            ->generateUrl();
        $targetUrlFdds = $adminUrlGenerator
            ->setController(self::class)
            ->setRoute('dashboard_creditor_images_fdds', ['id' => $id, 'name' => $name])
            ->setEntityId($id)
            ->generateUrl();
        return $this->render('admin/creditor/cdds.html.twig', [
            'cdds' => $cdds,
            'urlBoards' => $targetUrlBoards,
            'urlCards' => $targetUrlCards,
            'urlChips' => $targetUrlChips,
            'urlCpus' => $targetUrlCpus,
            'urlHdds' => $targetUrlHdds,
            'urlFdds' => $targetUrlFdds,
            'name' => $name,
        ]);
    }
    #[Route('/dashboard/creditorimages/fdds/{id}/{name}', name:'dashboard_creditor_images_fdds', requirements: ['id' => '\d+'])]
    public function creditorImagesFdds(
        int $id,
        string $name,
        FloppyDriveRepository $fddRepository,
        PaginatorInterface $paginatorInterface,
        AdminUrlGenerator $adminUrlGenerator,
        Request $request
    ): Response
    {
        $fdd_data = $fddRepository->findAllByCreditor($id);
        $fdds = $paginatorInterface->paginate($fdd_data, $request->query->getInt('page', 1), 50);
        $targetUrlBoards = $adminUrlGenerator
            ->setController(self::class)
            ->setRoute('dashboard_creditor_images_boards', ['id' => $id, 'name' => $name])
            ->setEntityId($id)
            ->generateUrl();
        $targetUrlCards = $adminUrlGenerator
            ->setController(self::class)
            ->setRoute('dashboard_creditor_images_cards', ['id' => $id, 'name' => $name])
            ->setEntityId($id)
            ->generateUrl();
        $targetUrlChips = $adminUrlGenerator
            ->setController(self::class)
            ->setRoute('dashboard_creditor_images_chips', ['id' => $id, 'name' => $name])
            ->setEntityId($id)
            ->generateUrl();
        $targetUrlCpus = $adminUrlGenerator
            ->setController(self::class)
            ->setRoute('dashboard_creditor_images_cpus', ['id' => $id, 'name' => $name])
            ->setEntityId($id)
            ->generateUrl();
        $targetUrlHdds = $adminUrlGenerator
            ->setController(self::class)
            ->setRoute('dashboard_creditor_images_hdds', ['id' => $id, 'name' => $name])
            ->setEntityId($id)
            ->generateUrl();
        $targetUrlCdds = $adminUrlGenerator
            ->setController(self::class)
            ->setRoute('dashboard_creditor_images_cdds', ['id' => $id, 'name' => $name])
            ->setEntityId($id)
            ->generateUrl();
        return $this->render('admin/creditor/fdds.html.twig', [
            'fdds' => $fdds,
            'urlBoards' => $targetUrlBoards,
            'urlCards' => $targetUrlCards,
            'urlChips' => $targetUrlChips,
            'urlCpus' => $targetUrlCpus,
            'urlHdds' => $targetUrlHdds,
            'urlCdds' => $targetUrlCdds,
            'name' => $name,
        ]);
    }
}
