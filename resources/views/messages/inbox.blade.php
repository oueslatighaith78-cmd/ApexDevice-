@extends('layouts.app')

@section('title', 'Messagerie — ApexDevice')

@section('styles')

<style>
    /* Masquer les éléments de recherche du header pour la messagerie */
.search-form, .cat-bar { display: none !important; }
.main-nav { border-bottom: 1px solid #e5e7eb; background: #fff; padding: 6px 0; }
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

    /* Sidebar Liste */
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
        background: #eef2ff;
        border-left: 4px solid var(--accent);
    }

    .conv-avatar {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: var(--accent-light);
        color: var(--accent);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 14px;
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
        margin-bottom: 4px;
    }

    .conv-name {
        font-weight: 700;
        font-size: 14.5px;
        color: var(--black);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .conv-time {
        font-size: 11px;
        color: var(--gray-400);
    }

    .conv-msg {
        font-size: 13px;
        color: var(--gray-600);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Right Side View */
    .inbox-view {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background: #fff;
        color: var(--gray-400);
        text-align: center;
        padding: 40px;
    }

    .inbox-view i {
        font-size: 50px;
        margin-bottom: 15px;
        opacity: 0.3;
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-4">
    <div class="messages-container">
        
        <!-- Sidebar : Liste des conversations -->
        <div class="inbox-sidebar">
            <div class="inbox-header">
                <h2>Messages</h2>
            </div>
            
            <div class="conversation-list">
                @forelse($messages->groupBy(function($m) {
                    return $m->sender_id == Auth::id() ? $m->receiver_id : $m->sender_id;
                }) as $userId => $group)
                    @php 
                        $other = $group->first()->sender_id == Auth::id() ? $group->first()->receiver : $group->first()->sender;
                        $last = $group->last();
                    @endphp
                    <a href="{{ route('messages.show', $other->id) }}" class="conv-item">
                        <div class="conv-avatar">
                            {{ strtoupper(substr($other->name, 0, 2)) }}
                        </div>
                        <div class="conv-details">
                            <div class="conv-top">
                                <span class="conv-name">{{ $other->name }}</span>
                                <span class="conv-time">{{ $last->created_at->diffForHumans(null, true) }}</span>
                            </div>
                            <div class="conv-msg">
                                @if($last->sender_id == Auth::id()) <span class="text-accent">Vous:</span> @endif
                                {{ $last->content }}
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="p-4 text-center text-muted small">Aucune conversation</div>
                @endforelse
            </div>
        </div>

        <!-- Main View : État vide ou instructions -->
        <div class="inbox-view">
            <i class="bi bi-chat-left-dots"></i>
            <h3>Sélectionnez une discussion</h3>
            <p>Choisissez un contact dans la liste pour voir vos messages.</p>
        </div>

    </div>
</div>
@endsection
