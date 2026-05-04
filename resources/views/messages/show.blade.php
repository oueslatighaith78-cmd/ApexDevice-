@extends('layouts.app')

@section('title', 'Conversation — ApexDevice')

@section('styles')
<style>
    .messages-container {
        display: grid;
        grid-template-columns: 350px 1fr;
        height: calc(100vh - 180px);
        min-height: 600px;
        background: #fff;
        border: 1px solid var(--gray-200);
        border-radius: 20px;
        overflow: hidden;
        margin-top: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }

    /* Sidebar : On garde la même que inbox pour la cohérence */
    .inbox-sidebar {
        border-right: 1px solid var(--gray-200);
        display: flex;
        flex-direction: column;
        background: #fcfcfb;
    }

    .inbox-header {
        padding: 24px;
        border-bottom: 1px solid var(--gray-200);
    }

    .inbox-header h2 {
        font-family: var(--font-display);
        font-size: 22px;
        font-weight: 800;
        margin: 0;
        color: var(--blue-dark);
    }

    .conversation-list {
        overflow-y: auto;
        flex: 1;
    }

    .conv-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 16px 20px;
        border-bottom: 1px solid var(--gray-50);
        text-decoration: none;
        color: inherit;
        transition: all 0.2s;
    }

    .conv-item:hover {
        background: #f0f4ff;
        text-decoration: none;
        color: inherit;
    }

    .conv-item.active {
        background: #f0f4ff;
        border-left: 4px solid var(--accent);
    }

    .conv-avatar {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: var(--accent-light);
        color: var(--accent);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 13px;
        flex-shrink: 0;
    }

    .conv-details {
        flex: 1;
        min-width: 0;
    }

    .conv-top {
        display: flex;
        justify-content: space-between;
        align-items: baseline;
    }

    .conv-name {
        font-weight: 700;
        font-size: 14px;
        color: var(--black);
    }

    .conv-time {
        font-size: 10px;
        color: var(--gray-400);
    }

    /* Zone de Chat */
    .chat-view {
        display: flex;
        flex-direction: column;
        background: #fff;
    }

    .chat-view-header {
        padding: 16px 24px;
        border-bottom: 1px solid var(--gray-200);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .chat-user-profile {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .chat-user-profile h4 {
        font-size: 16px;
        font-weight: 700;
        margin: 0;
    }

    .chat-user-profile .status {
        font-size: 12px;
        color: var(--green);
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .chat-messages-area {
        flex: 1;
        overflow-y: auto;
        padding: 24px;
        background: #fdfdfd;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .msg-wrapper {
        display: flex;
        flex-direction: column;
        max-width: 75%;
    }

    .msg-wrapper.sent {
        align-self: flex-end;
        align-items: flex-end;
    }

    .msg-wrapper.received {
        align-self: flex-start;
        align-items: flex-start;
    }

    .msg-bubble {
        padding: 12px 18px;
        border-radius: 18px;
        font-size: 14.5px;
        line-height: 1.4;
    }

    .sent .msg-bubble {
        background: var(--blue-dark);
        color: #fff;
        border-bottom-right-radius: 4px;
    }

    .received .msg-bubble {
        background: #f1f1f1;
        color: var(--black);
        border-bottom-left-radius: 4px;
    }

    .msg-time {
        font-size: 10px;
        color: var(--gray-400);
        margin-top: 5px;
    }

    /* Formulaire */
    .chat-footer {
        padding: 20px 24px;
        border-top: 1px solid var(--gray-200);
    }

    .chat-form {
        display: flex;
        gap: 12px;
        align-items: center;
    }

    .chat-input {
        flex: 1;
        border: 1.5px solid var(--gray-200);
        border-radius: 12px;
        padding: 12px 20px;
        background: var(--gray-50);
        font-size: 14px;
        outline: none;
        transition: 0.2s;
    }

    .chat-input:focus {
        border-color: var(--accent);
        background: #fff;
    }

    .product-select {
        border: 1.5px solid var(--gray-200);
        border-radius: 12px;
        padding: 12px;
        font-size: 13px;
        width: 150px;
    }

    .send-btn {
        background: var(--accent);
        color: #fff;
        border: none;
        width: 46px;
        height: 46px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: 0.2s;
    }

    .send-btn:hover {
        background: var(--accent-dark);
        transform: scale(1.05);
    }

    .product-tag {
        font-size: 11px;
        background: rgba(255,255,255,0.2);
        padding: 2px 8px;
        border-radius: 10px;
        margin-top: 5px;
        display: inline-block;
    }
    .received .product-tag { background: rgba(0,0,0,0.05); }
</style>
@endsection

@section('content')
<div class="container-fluid px-4">
    <div class="messages-container">
        
        <!-- Sidebar : Même liste que inbox -->
        <div class="inbox-sidebar">
            <div class="inbox-header">
                <h2>Messages</h2>
            </div>
            <div class="conversation-list">
                @foreach(App\Models\Message::where('sender_id', Auth::id())->orWhere('receiver_id', Auth::id())->get()->groupBy(function($m) {
                    return $m->sender_id == Auth::id() ? $m->receiver_id : $m->sender_id;
                }) as $uId => $group)
                    @php $o = $group->first()->sender_id == Auth::id() ? $group->first()->receiver : $group->first()->sender; @endphp
                   <a href="{{ route('messages.show', $o->id) }}" class="conv-item {{ $o->id == $receiver->id ? 'active' : '' }}">

                        <div class="conv-avatar">{{ strtoupper(substr($o->name, 0, 2)) }}</div>
                        <div class="conv-details">
                            <div class="conv-top">
                                <span class="conv-name">{{ $o->name }}</span>
                                <span class="conv-time">{{ $group->last()->created_at->diffForHumans(null, true) }}</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Zone de Chat -->
        <div class="chat-view">
            <div class="chat-view-header">
                <div class="chat-user-profile">
                    <div class="conv-avatar">{{ strtoupper(substr($receiver->name, 0, 2)) }}</div>
                    <div>
                        <h4>{{ $receiver->name }}</h4>
                        <span class="status"><i class="bi bi-circle-fill" style="font-size: 8px;"></i> En ligne</span>
                    </div>
                </div>
            </div>

            <div id="chat-box" class="chat-messages-area">
                @foreach($messages as $msg)
                    <div class="msg-wrapper {{ $msg->sender_id == Auth::id() ? 'sent' : 'received' }}">
                        <div class="msg-bubble">
                            {{ $msg->content }}
                            @if($msg->product)
                                <div class="product-tag">📦 {{ $msg->product->title }}</div>
                            @endif
                        </div>
                        <span class="msg-time">{{ $msg->created_at->format('H:i') }}</span>
                    </div>
                @endforeach
            </div>

            <div class="chat-footer">
                <form action="{{ route('messages.store', $receiver->id) }}" method="POST" class="chat-form">
                    @csrf
                    <input type="text" name="content" class="chat-input" placeholder="Tapez votre message..." required autofocus>
                    <select name="product_id" class="product-select">
                        <option value="">-- Produit --</option>
                        @foreach($products as $p)
                            <option value="{{ $p->id }}">{{ $p->title }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="send-btn">
                        <i class="bi bi-send-fill"></i>
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection

@section('scripts')
<script>
    const cb = document.getElementById('chat-box');
    cb.scrollTop = cb.scrollHeight;
</script>
@endsection
