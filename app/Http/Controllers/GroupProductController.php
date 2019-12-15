<?php

namespace App\Http\Controllers;

use App\GroupProduct;
use Illuminate\Http\Request;

class GroupProductController extends Controller
{
    public function destroy(GroupProduct $groupProduct)
    {
        $groupProduct->Deleted = 1;
        return $groupProduct->save();
    }
}
