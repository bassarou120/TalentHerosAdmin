<?php

namespace App\Filament\Pages;

use App\Models\Message;
use App\Models\User;
use Filament\Pages\Page;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;


class SendMessage extends Page
{


    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.send-message';
    public $receiver_id;
    public $message;
    public function submit()
    {

        foreach ($this->receiver_id as $receiverId) {
            Message::create([
                'sender_id' => auth()->id(),
                'receiver_id' => $receiverId,
                'message' => $this->message,
            ]);
        }



//        $this->notify('success', 'Message envoyé avec succès!');
    }

    protected function getFormSchema(): array
    {
        return [
            Select::make('receiver_id')
                ->label('Destinataire')
                ->options(User::all()->pluck('name', 'id'))
                ->multiple()
                ->required(),
           Textarea::make('message')
                ->label('Message')
                ->required(),
        ];
    }



//    public function render()
//    {
//        return view('filament.pages.send-message', [
//            'form' => $this->form,
//        ]);
//    }


}
