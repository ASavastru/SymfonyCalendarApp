<?php

namespace App\Controller;

use App\Entity\Appointments;
use App\Entity\Locations;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AppointmentController extends AbstractController
{
    public function __construct(protected EntityManagerInterface $db)
    {
    }

    #[Route('/getAppointments', name: 'app_get_appointment')]
    public function getAppointments(Request $request): Response
    {
        $appointments = $this->db->getRepository(Appointments::class)->findBy([
            "Date" => \DateTime::createFromFormat('Y-m-d', $request->request->get("date")),
            "Location_ID" => $request->request->get("location"),
        ]);
        $response = [];
        foreach($appointments as $key => $appointment){
            $response[$key] = [
                'name' => $appointment->getUser()->getName(),
                'location' => $appointment->getLocation()->getAddress(),
            ];
        }
        return new JsonResponse($response);
    }

    #[Route('/setAppointments', name: 'app_set_appointment')]
    public function setAppointments(Request $request): Response
    {
        $user = $this->getUser();
        $targetAppointment = $this->db->getRepository(Appointments::class)->findOneBy([
            'User_ID' => $user->getId(),
            'Date' => \DateTime::createFromFormat('Y-m-d', $request->request->get("date")),
        ]);

        if($targetAppointment){
            return new JsonResponse(['error' => 'You Already Have An Appointment On This Date']);
        }

        $capacity = $this->db->getRepository(Locations::class)->findOneBy(['id' => $request->request->get('location')])->getCapacity();
        $appointmentsOnGivenDate = $this->db->getRepository(Appointments::class)->findBy([
            'Date' => \DateTime::createFromFormat('Y-m-d', $request->request->get("date")),
        ]);

        if(count($appointmentsOnGivenDate)>$capacity){
            return new JsonResponse(['error' => 'No More Room For U :(']);
        }

        if(date('Y-m-d')>date('Y-m-d', strtotime($request->request->get("date")))){
            return new JsonResponse(['error' => 'You Cannot Make Appointments In The Past']);
        }

        $location = $this->db->getRepository(Locations::class)->findOneBy([
            'id' => $request->request->get('location'),
        ]);
        $appointments = new Appointments();
        $appointments->setDate(\DateTime::createFromFormat('Y-m-d', $request->request->get("date")));
        $appointments->setLocation( $location);
        $appointments->setUser($user);
        $this->db->persist($appointments);
        $this->db->flush();

        return new JsonResponse(null);
    }
}