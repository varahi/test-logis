<?php

declare(strict_types=1);

namespace App\Controller\Traits;

trait DataTrait
{
    public function getJsonArrData($items)
    {
        if ($items) {
            foreach ($items as $item) {
                if ($item->getId()) {
                    $itemId = $item->getId();
                }
                if ($item->getTitle()) {
                    $itemTitle = $item->getTitle();
                } else {
                    $itemTitle = null;
                }
                if ($item->getDescription()) {
                    $itemDescription = $item->getDescription();
                } else {
                    $itemDescription = null;
                }

                $arrData[] = [
                    'id' => $itemId,
                    'title' => $itemTitle,
                    'description' => $itemDescription
                ];
            }
            return $arrData;
        } else {
            return null;
        }
    }
}
