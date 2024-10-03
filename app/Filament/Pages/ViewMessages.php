<?php

namespace App\Filament\Pages;

use App\Models\Message;
use Filament\Pages\Page;
use Filament\Forms;

use App\Models\User;



class ViewMessages extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.view-messages';


    public $messages;

    public function mount()
    {
      $this->messages = Message::with('sender')->get();
//        $this->messages =  Message::where('receiver_id', auth()->id())->get();

//        dd(  $this->messages);
    }


    public function getMessages()
    {

        return Message::where('receiver_id', auth()->id())->get();
    }

    public function markAsRead($messageId)
    {
        $message = Message::find($messageId);
        $message->update(['is_read' => true]);

        $this->notify('success', 'Message marqué comme lu!');
    }

//    public function render()
//    {
//        return view('filament.pages.view-messages', [
//            'messages' => $this->getMessages(),
//        ]);
//    }
}
