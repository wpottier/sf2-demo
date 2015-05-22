<?php

namespace Mon\QcmBundle\Mailer;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Templating\EngineInterface;

class AbstractMailer 
{
    /**
     * @var EngineInterface
     */
    protected $templating;

    /**
     * @var \Swift_Mailer
     */
    protected $mailer;

    /**
     * @var RouterInterface
     */
    protected $router;

    /**
     * @var string
     */
    protected $senderName;

    /**
     * @var string
     */
    protected $senderEmail;

    /**
     * @param EngineInterface $templating
     * @param \Swift_Mailer   $mailer
     * @param RouterInterface $router
     * @param string          $senderName
     * @param string          $senderEmail
     */
    public function __construct(EngineInterface $templating, \Swift_Mailer $mailer, RouterInterface $router, $senderName, $senderEmail)
    {
        $this->templating  = $templating;
        $this->mailer      = $mailer;
        $this->router      = $router;
        $this->senderName  = $senderName;
        $this->senderEmail = $senderEmail;
    }

    /**
     * @param       $route
     * @param array $parameters
     * @param bool  $absolute
     *
     * @return string
     */
    protected function generateUrl($route, $parameters = array(), $absolute = true)
    {
        // use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
        return $this->router->generate(
            $route,
            $parameters,
            $absolute ? UrlGeneratorInterface::ABSOLUTE_URL : UrlGeneratorInterface::RELATIVE_PATH
        );
    }

    /**
     * @param       $name
     * @param array $parameters
     *
     * @return string
     */
    protected function render($name, $parameters = array())
    {
        return $this->templating->render($name, $parameters);
    }

    /**
     * @param null $subjet
     *
     * @return \Swift_Message
     */
    protected function create($subjet = null)
    {
        $message = \Swift_Message::newInstance($subjet);
        $message->setFrom($this->senderEmail, $this->senderName);

        return $message;
    }

    /**
     * @param \Swift_Message $message
     */
    protected function send(\Swift_Message $message)
    {
        $this->mailer->send($message);
    }
}