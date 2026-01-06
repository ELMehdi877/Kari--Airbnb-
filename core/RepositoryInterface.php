<?php

interface RepositoryInterface {
    public function save(object $entity);
    public function find(string $stirng);
}