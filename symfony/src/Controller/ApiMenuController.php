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

    // 1. Отримання всіх страв (GET)
    #[Route('/api/menu', name: 'api_menu_index', methods: ['GET'])]
    public function index(): JsonResponse
    {
        return $this->json(self::$menu);
    }

    // 2. Створення нової страви (POST)
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

    // 3. Отримання однієї страви за ID (GET)
    #[Route('/api/menu/{id}', name: 'api_menu_show', methods: ['GET'])]
    public function show(int $id): JsonResponse
    {
        foreach (self::$menu as $item) {
            if ($item['id'] === $id) {
                return $this->json($item);
            }
        }

        return $this->json(['message' => 'страва не знайдена'], 404);
    }

    // 4. Оновлення страви за ID (PATCH)
    #[Route('/api/menu/{id}', name: 'api_menu_update', methods: ['PATCH'])]
    public function update(int $id, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        foreach (self::$menu as &$item) {
            if ($item['id'] === $id) {
                if (isset($data['name'])) $item['name'] = $data['name'];
                if (isset($data['description'])) $item['description'] = $data['description'];
                if (isset($data['price'])) $item['price'] = (float)$data['price'];

                return $this->json($item);
            }
        }

        return $this->json(['message' => 'страва не знайдена'], 404);
    }

    // 5. Видалення страви за ID (DELETE)
    #[Route('/api/menu/{id}', name: 'api_menu_destroy', methods: ['DELETE'])]
    public function destroy(int $id): JsonResponse
    {
        foreach (self::$menu as $key => $item) {
            if ($item['id'] === $id) {
                unset(self::$menu[$key]);
                // скидаємо індекси масиву для коректності
                self::$menu = array_values(self::$menu);
                
                return $this->json(['message' => 'страву видалено успішно']);
            }
        }

        return $this->json(['message' => 'страва не знайдена'], 404);
    }
}