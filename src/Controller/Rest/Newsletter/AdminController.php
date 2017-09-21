<?php

/**
 * Pimcore Customer Management Framework Bundle
 * Full copyright and license information is available in
 * License.md which is distributed with this source code.
 *
 * @copyright  Copyright (C) Elements.at New Media Solutions GmbH
 * @license    GPLv3
 */

namespace CustomerManagementFrameworkBundle\Controller\Rest\Newsletter;

use CustomerManagementFrameworkBundle\Newsletter\Queue\NewsletterQueueInterface;
use Pimcore\Bundle\AdminBundle\Controller\Rest\AbstractRestController;
use Pimcore\Tool\Console;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractRestController
{
    /**
     * @Route("/newsletter/enqueue-all-customers")
     * @Method({"GET"})
     */
    public function enqueueAllCustomers()
    {
        $php = Console::getExecutable('php');
        Console::execInBackground($php . ' ' . PIMCORE_PROJECT_ROOT . '/bin/console cmf:newsletter-sync --enqueue-all-customers -c');

        return new JsonResponse('ok');
    }

    /**
     * @Route("/newsletter/get-queue-size")
     * @Method({"GET"})
     */
    public function getQueueSize()
    {
        /**
         * @var NewsletterQueueInterface $queue
         */
        $queue = $this->container->get(NewsletterQueueInterface::class);

        return new JsonResponse(['size'=>$queue->getQueueSize()]);
    }
}