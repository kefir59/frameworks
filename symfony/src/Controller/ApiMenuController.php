<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class ApiMenuController extends AbstractController
{
    // імітація бази даних у вигляді статичного масиву
    private static array $menu = [
        ['id' => 1, 'name' => 'Pizza Margarita', 'description' => 'Classic pizza with tomatoes', 'price' => 185.50]
    ];

    // отримання всіх страв (GET)
    #[Route('/api/menu', name: 'api_menu_index', methods: ['GET'])]
    public function index(): JsonResponse
    {
        return $this->json(self::$menu);
    }

    // створення нової страви (POST)
    #[Route('/api/menu', name: 'api_menu_store', methods: ['POST'])]
    public function store(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (empty($data['name']) || empty($data['price'])) {
            return $this->json(['message' => 'відсутні обовʼязкові поля'], 400);
        }

        $newItem = [
            'id' => count(self::$menu) + 1,
            'name' => $data['name'],
            'description' => $data['description'] ?? '',
            'price' => (float)$data['price']
        ];

        self::$menu[] = $newItem;

        return $this->json($newItem, 201);
    }
}