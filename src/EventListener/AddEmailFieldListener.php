<?php

namespace App\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class AddEmailFieldListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            FormEvents::PRE_SET_DATA => 'onPreSetData',
            // FormEvents::PRE_SUBMIT   => 'onPreSubmit',
        ];
    }

    public function onPreSetData(FormEvent $event): void
    {
        $article = $event->getData();
        $form = $event->getForm();

        // dd($article);

        if($article->getEmail()){
            $form->remove('email', ArticleType::class);
        }
    }
}
