<?php

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class CustomDataExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('save_data', [$this, 'save_data']),
            new TwigFunction('get_data', [$this, 'get_data']),
            new TwigFunction('update_data_by_id', [$this, 'update_data_by_id']),
            new TwigFunction('delete_data_by_id', [$this, 'delete_data_by_id']),
            new TwigFunction('get_data_by_id', [$this, 'get_data_by_id']),
            new TwigFunction('get_data_count', [$this, 'get_data_count']),
        ];
    }

    public function save_data(string $name, string $value): int
    {
        return CustomData::query()->insert(['key' => $name, 'data' => $value]);
    }

    public function get_data(string $name, int $perPage = 10, int $page = 1): array
    {
        return CustomData::query()
            ->where('key', $name)
            ->offset($perPage * ($page - 1))
            ->limit($perPage)
            ->get();
    }

    public function get_data_by_id(string $name, int $id)
    {
        return CustomData::query()
            ->where('key', $name)
            ->where('id', $id)
            ->first();
    }

    public function update_data_by_id(string $name, int $id, string $value): int
    {
        return CustomData::query()
            ->where('key', $name)
            ->where('id', $id)
            ->update(['data' => $value]);
    }

    public function delete_data_by_id(string $name, int $id): int
    {
        return CustomData::query()
            ->where('key', $name)
            ->where('id', $id)
            ->delete();
    }

    public function get_data_count(string $name): int
    {
        return CustomData::query()
            ->where('key', $name)
            ->count();
    }
}
