<?php

interface RepositoryInterface {
    public function save(object $entity);
    public function findByEmail(string $email);
}