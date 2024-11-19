<?php

namespace App\Http\Controllers\Global;

use App\Http\Controllers\Controller;
use App\Models\MiscPages;
use App\Traits\HandleResponseTrait;
use Illuminate\Http\Request;

class MiscController extends Controller
{
    use HandleResponseTrait;

    public function about(){
        $about = MiscPages::select('about')->first();
        return $this->handleResponse(
            true,
            "",
            [],
            [
                 $about
            ],
            []
        );
    }
    public function privacyTerms(){
        $privacyTerms = MiscPages::select('privacy_terms')->first();
        return $this->handleResponse(
            true,
            "",
            [],
            [
                 $privacyTerms
            ],
            []
        );
    }
    public function faq(){
        $faq = MiscPages::select('faq')->first();
        return $this->handleResponse(
            true,
            "",
            [],
            [
                 $faq
            ],
            []
        );
    }
    public function contact(){
        $contact = MiscPages::select('contact_us')->first();
        return $this->handleResponse(
            true,
            "",
            [],
            [
                 $contact
            ],
            []
        );
    }
}
