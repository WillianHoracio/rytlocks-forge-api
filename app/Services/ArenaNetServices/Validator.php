<?php 
namespace App\Services\ArenaNetServices;

use App\Exceptions\Gw2ApiException;

class Validator
{
    public function validateIds(array $ids) {
        if (empty($ids)) {
            throw new Gw2ApiException('Error: No IDs provided for the request. The array sent is empty.', 000);
        }

        foreach ($ids as $id) {
            if (!is_int($id)) {
                throw new Gw2ApiException("Error: The ID '{$id}' is not numeric. Sent array: " . json_encode($ids), 000);
            }
            if ($id <= 0) {
                throw new Gw2ApiException("Error: The ID '{$id}' must be greater than 0. Sent array: " . json_encode($ids), 000);
            }
        }
    }

    public function validateId(int $id) {
        if ($id <= 0) {
            throw new Gw2ApiException("Error: The ID '{$id}' must be greater than 0.");
        }
    }
}
