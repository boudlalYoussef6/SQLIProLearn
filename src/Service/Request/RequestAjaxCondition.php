<?php

declare(strict_types=1);

namespace App\Service\Request;

use Symfony\Bundle\FrameworkBundle\Routing\Attribute\AsRoutingConditionService;
use Symfony\Component\HttpFoundation\Request;

#[AsRoutingConditionService(alias: 'post_ajax_checker')]
class RequestAjaxCondition
{
    public function isAjaxPostRequest(Request $request): bool
    {
        return $request->isMethod(Request::METHOD_POST) && $request->isXmlHttpRequest();
    }
}
