@extends('layouts.app')

@section('content')

{{-- Particle Background --}}
<div class="particles-bg" aria-hidden="true">
    <div class="particle"></div><div class="particle"></div><div class="particle"></div>
    <div class="particle"></div><div class="particle"></div><div class="particle"></div>
    <div class="particle"></div><div class="particle"></div><div class="particle"></div>
</div>

<div class="dashboard-wrapper">

    {{-- ══════════ HEADER ══════════ --}}
    <header class="dash-header reveal-down">
        <div class="dash-header__icon">
            <svg class="icon-svg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"/>
            </svg>
        </div>
        <div class="dash-header__text">
            <h1 class="dash-header__title">Admin <span class="title-accent">Dashboard</span></h1>
            <p class="dash-header__sub">Vue d'ensemble &amp; statistiques en temps réel</p>
        </div>
        <div class="dash-header__badge">
            <span class="live-dot"></span> Live
        </div>
    </header>

    {{-- ══════════ STATS GRID ══════════ --}}
    <section class="stats-grid">

        {{-- Card: Véhicules --}}
        <div class="stat-card stat-card--blue reveal-up" style="--delay: 0.08s">
            <div class="stat-card__glow"></div>
            <div class="stat-card__top">
                <div class="stat-card__label">
                    <div class="stat-icon stat-icon--blue">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                    </div>
                    <span>Véhicules</span>
                </div>
                <div class="stat-card__badge-circle stat-icon--blue">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <p class="stat-card__number counter" data-target="{{ $vehicules ?? 0 }}">{{ $vehicules ?? 0 }}</p>
            <div class="stat-card__meta">
                <span class="meta-dot meta-dot--green"></span>
                <span class="meta-text">Actifs ·</span>
                <span class="meta-highlight">{{ ($vehicules ?? 0) > 0 ? round(($vehicules_disponibles ?? 0) / ($vehicules ?? 1) * 100) : 0 }}% disponibles</span>
            </div>
            <div class="stat-card__bar">
                <div class="stat-card__bar-fill" style="--bar-w: {{ ($vehicules ?? 0) > 0 ? round(($vehicules_disponibles ?? 0) / ($vehicules ?? 1) * 100) : 0 }}%"></div>
            </div>
            <div class="stat-card__shine"></div>
        </div>

        {{-- Card: Chauffeurs --}}
        <div class="stat-card stat-card--emerald reveal-up" style="--delay: 0.16s">
            <div class="stat-card__glow"></div>
            <div class="stat-card__top">
                <div class="stat-card__label">
                    <div class="stat-icon stat-icon--emerald">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    <span>Chauffeurs</span>
                </div>
                <div class="stat-card__badge-circle stat-icon--emerald">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
            </div>
            <p class="stat-card__number counter" data-target="{{ $chauffeurs ?? 0 }}">{{ $chauffeurs ?? 0 }}</p>
            <div class="stat-card__meta">
                <span class="meta-text">👥 Personnel actif</span>
            </div>
            @php
                $chauffeurs_pct = ($vehicules ?? 0) > 0
                    ? min(100, round(($chauffeurs ?? 0) / max(1, ($vehicules ?? 1)) * 100))
                    : (($chauffeurs ?? 0) > 0 ? 100 : 0);
            @endphp
            <div class="stat-card__bar">
                <div class="stat-card__bar-fill" style="--bar-w: {{ $chauffeurs_pct }}%"></div>
            </div>
            <div class="stat-card__shine"></div>
        </div>

        {{-- Card: Voyages --}}
        <div class="stat-card stat-card--amber reveal-up" style="--delay: 0.24s">
            <div class="stat-card__glow"></div>
            <div class="stat-card__top">
                <div class="stat-card__label">
                    <div class="stat-icon stat-icon--amber">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    </div>
                    <span>Voyages</span>
                </div>
                <div class="stat-card__badge-circle stat-icon--amber">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                </div>
            </div>
            <p class="stat-card__number counter" data-target="{{ $voyages ?? 0 }}">{{ $voyages ?? 0 }}</p>
            <div class="stat-card__meta">
                @if(($voyages_today ?? 0) > 0)
                    <span class="meta-dot meta-dot--green"></span>
                    <span class="meta-text">{{ $voyages_today ?? 0 }} aujourd'hui ·</span>
                    <span class="meta-highlight">{{ $voyages_mois ?? 0 }} ce mois</span>
                @else
                    <span class="meta-text">🚀 {{ $voyages_mois ?? 0 }} ce mois</span>
                @endif
            </div>
            @php
                $voyages_pct = ($voyages ?? 0) > 0 ? min(100, round(($voyages_mois ?? 0) / max(1, $voyages) * 100)) : 0;
            @endphp
            <div class="stat-card__bar">
                <div class="stat-card__bar-fill" style="--bar-w: {{ $voyages_pct }}%"></div>
            </div>
            <div class="stat-card__shine"></div>
        </div>

        {{-- Card: Alertes --}}
        <div class="stat-card stat-card--red reveal-up {{ ($alertes ?? 0) > 0 ? 'stat-card--alert' : '' }}" style="--delay: 0.32s">
            <div class="stat-card__glow"></div>
            @if(($alertes ?? 0) > 0)
            <div class="alert-ring">
                <span class="alert-ring__ping"></span>
                <span class="alert-ring__dot"></span>
            </div>
            @endif
            <div class="stat-card__top">
                <div class="stat-card__label">
                    <div class="stat-icon stat-icon--red">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </div>
                    <span>Alertes</span>
                </div>
                <div class="stat-card__badge-circle stat-icon--red">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                </div>
            </div>
            <p class="stat-card__number counter {{ ($alertes ?? 0) > 0 ? 'stat-card__number--alert' : '' }}" data-target="{{ $alertes ?? 0 }}">{{ $alertes ?? 0 }}</p>
            <div class="stat-card__meta">
                <span class="meta-text">⚠️ Actions nécessaires</span>
            </div>
            <div class="stat-card__bar">
                <div class="stat-card__bar-fill" style="--bar-w: {{ ($alertes ?? 0) > 0 ? '100%' : '0%' }}"></div>
            </div>
            <div class="stat-card__shine"></div>
        </div>

        {{-- Card: Documents --}}
        <div class="stat-card stat-card--purple reveal-up" style="--delay: 0.40s">
            <div class="stat-card__glow"></div>
            <div class="stat-card__top">
                <div class="stat-card__label">
                    <div class="stat-icon stat-icon--purple">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <span>Documents</span>
                </div>
                <div class="stat-card__badge-circle stat-icon--purple">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                </div>
            </div>
            <p class="stat-card__number counter" data-target="{{ $documents ?? 0 }}">{{ $documents ?? 0 }}</p>
            <div class="stat-card__meta docs-meta">
                <span class="tag tag--orange">📄 {{ $docs_bientot ?? 0 }} bientôt expirés</span>
                <span class="tag tag--red">⚠️ {{ $docs_expire ?? 0 }} expirés</span>
            </div>
            <div class="stat-card__shine"></div>
        </div>

        {{-- Card: Recette Mensuelle --}}
        <div class="stat-card stat-card--green reveal-up stat-card--wide" style="--delay: 0.48s">
            <div class="stat-card__glow"></div>
            <div class="stat-card__top">
                <div class="stat-card__label">
                    <div class="stat-icon stat-icon--green">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <span>Recette Mensuelle</span>
                </div>
                @if(($recettes_evolution ?? 0) >= 0)
                    <span class="growth-badge">
                        <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                        +{{ $recettes_evolution ?? 0 }}%
                    </span>
                @else
                    <span class="growth-badge" style="background:rgba(239,68,68,0.15);border-color:rgba(239,68,68,0.25);color:#f87171;">
                        <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17H5m0 0V9m0 8l8-8 4 4 6-6"/></svg>
                        {{ $recettes_evolution ?? 0 }}%
                    </span>
                @endif
            </div>
            <p class="stat-card__number stat-card__number--green">{{ number_format($recettes ?? 0, 0, ',', ' ') }} <small>FCFA</small></p>
            <p class="stat-card__meta"><span class="meta-text">vs mois précédent</span></p>
            <div class="revenue-bar-track">
                <div class="revenue-bar-fill" style="--bar-w: {{ $recettes_pct ?? 0 }}%"></div>
                <span class="revenue-bar-label">{{ $recettes_pct ?? 0 }}%</span>
            </div>
            <div class="stat-card__shine"></div>
        </div>

    </section>

    {{-- ══════════ BOTTOM PANELS ══════════ --}}
    <section class="panels-grid reveal-up" style="--delay: 0.56s">

        {{-- Quick Actions --}}
        <div class="panel">
            <div class="panel__header">
                <div class="panel__icon panel__icon--blue">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <h3 class="panel__title">Actions Rapides</h3>
            </div>
            <div class="actions-grid">
                <a href="#" class="action-btn">
                    <div class="action-btn__icon action-btn__icon--blue">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    </div>
                    <span>Nouveau véhicule</span>
                </a>
                <a href="#" class="action-btn">
                    <div class="action-btn__icon action-btn__icon--emerald">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <span>Ajouter document</span>
                </a>
                <a href="#" class="action-btn">
                    <div class="action-btn__icon action-btn__icon--amber">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    </div>
                    <span>Rapport mensuel</span>
                </a>
                <a href="#" class="action-btn">
                    <div class="action-btn__icon action-btn__icon--purple">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    <span>Gérer chauffeurs</span>
                </a>
            </div>
        </div>

        {{-- Status Summary --}}
        <div class="panel">
            <div class="panel__header">
                <div class="panel__icon panel__icon--green">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h3 class="panel__title">Statut du Jour</h3>
            </div>
            <div class="status-list">
                <div class="status-row">
                    <span class="status-row__label">
                        <span class="status-dot status-dot--amber"></span>
                        Véhicules en mission
                    </span>
                    <span class="status-row__value" style="color:#fbbf24">{{ $vehicules_mission ?? 0 }}</span>
                </div>
                <div class="status-row">
                    <span class="status-row__label">
                        <span class="status-dot status-dot--green"></span>
                        Véhicules disponibles
                    </span>
                    <span class="status-row__value" style="color:#4ade80">{{ $vehicules_disponibles ?? 0 }}</span>
                </div>
                <div class="status-row">
                    <span class="status-row__label">
                        <span class="status-dot status-dot--blue"></span>
                        Maintenance en cours
                    </span>
                    <span class="status-row__value" style="color:#60a5fa">{{ $vehicules_maintenance ?? 0 }}</span>
                </div>
                <div class="status-row status-row--total">
                    <span class="status-row__label--total">Taux d'occupation</span>
                    <span class="status-row__value status-row__value--green">{{ number_format($occupation ?? 0, 1) }}%</span>
                </div>
                <div class="occupation-track">
                    <div class="occupation-fill" style="--occ: {{ number_format($occupation ?? 0, 1) }}%"></div>
                </div>
            </div>
        </div>

    </section>
</div>

{{-- ══════════════════════════════════════════ --}}
{{-- STYLES                                       --}}
{{-- ══════════════════════════════════════════ --}}
<style>
/* ── Fonts ─────────────────────────────── */
@import url('https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap');

/* ── Variables ─────────────────────────── */
:root {
    --blue:    #3b82f6;
    --emerald: #10b981;
    --amber:   #f59e0b;
    --red:     #ef4444;
    --purple:  #a855f7;
    --green:   #22c55e;

    --bg-card:    rgba(255,255,255,0.04);
    --bg-card-h:  rgba(255,255,255,0.08);
    --border:     rgba(255,255,255,0.09);
    --border-h:   rgba(255,255,255,0.18);
    --text-primary: #f1f5f9;
    --text-muted:   #64748b;
    --text-sub:     #94a3b8;

    --font-display: 'Syne', sans-serif;
    --font-body:    'DM Sans', sans-serif;

    --ease-spring: cubic-bezier(0.34, 1.56, 0.64, 1);
    --ease-smooth: cubic-bezier(0.4, 0, 0.2, 1);
}

/* ── Base ──────────────────────────────── */
.dashboard-wrapper {
    position: relative;
    font-family: var(--font-body);
    display: flex;
    flex-direction: column;
    gap: 2rem;
    padding: 0.5rem 0 2rem;
    z-index: 1;
}

/* ── Particle Background ───────────────── */
.particles-bg {
    position: fixed;
    inset: 0;
    pointer-events: none;
    overflow: hidden;
    z-index: 0;
}
.particle {
    position: absolute;
    border-radius: 50%;
    opacity: 0;
    animation: floatParticle 12s infinite;
}
.particle:nth-child(1)  { width:3px;  height:3px;  background:var(--blue);    left:10%; animation-delay:0s;    animation-duration:14s; }
.particle:nth-child(2)  { width:4px;  height:4px;  background:var(--emerald); left:20%; animation-delay:2s;    animation-duration:11s; }
.particle:nth-child(3)  { width:2px;  height:2px;  background:var(--amber);   left:35%; animation-delay:4s;    animation-duration:16s; }
.particle:nth-child(4)  { width:5px;  height:5px;  background:var(--purple);  left:50%; animation-delay:1s;    animation-duration:13s; }
.particle:nth-child(5)  { width:3px;  height:3px;  background:var(--green);   left:65%; animation-delay:3s;    animation-duration:15s; }
.particle:nth-child(6)  { width:2px;  height:2px;  background:var(--red);     left:75%; animation-delay:5s;    animation-duration:12s; }
.particle:nth-child(7)  { width:4px;  height:4px;  background:var(--blue);    left:85%; animation-delay:0.5s;  animation-duration:17s; }
.particle:nth-child(8)  { width:3px;  height:3px;  background:var(--amber);   left:45%; animation-delay:6s;    animation-duration:10s; }
.particle:nth-child(9)  { width:2px;  height:2px;  background:var(--emerald); left:90%; animation-delay:2.5s;  animation-duration:14s; }

@keyframes floatParticle {
    0%   { transform: translateY(100vh) scale(0); opacity: 0; }
    10%  { opacity: 0.6; }
    90%  { opacity: 0.4; }
    100% { transform: translateY(-10vh) scale(1.2); opacity: 0; }
}

/* ── Header ────────────────────────────── */
.dash-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.5rem 1.75rem;
    background: linear-gradient(135deg, rgba(255,255,255,0.06) 0%, rgba(255,255,255,0.02) 100%);
    border: 1px solid var(--border);
    border-radius: 20px;
    backdrop-filter: blur(20px);
    position: relative;
    overflow: hidden;
}
.dash-header::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 1px;
    background: linear-gradient(90deg, transparent, rgba(99,102,241,0.6), rgba(168,85,247,0.6), transparent);
}
.dash-header__icon {
    width: 52px; height: 52px;
    border-radius: 16px;
    background: linear-gradient(135deg, #6366f1, #a855f7);
    display: grid; place-items: center;
    box-shadow: 0 8px 24px rgba(99,102,241,0.35), inset 0 1px 0 rgba(255,255,255,0.2);
    flex-shrink: 0;
    animation: iconFloat 4s ease-in-out infinite;
}
@keyframes iconFloat {
    0%, 100% { transform: translateY(0) rotate(0deg); }
    50%       { transform: translateY(-3px) rotate(2deg); }
}
.icon-svg { width: 24px; height: 24px; color: #fff; }
.dash-header__text { flex: 1; }
.dash-header__title {
    font-family: var(--font-display);
    font-size: 1.75rem;
    font-weight: 800;
    color: var(--text-primary);
    line-height: 1.1;
    letter-spacing: -0.03em;
}
.title-accent {
    background: linear-gradient(90deg, #818cf8, #c084fc);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
.dash-header__sub {
    font-size: 0.8rem;
    color: var(--text-muted);
    margin-top: 0.25rem;
    font-weight: 300;
    letter-spacing: 0.01em;
}
.dash-header__badge {
    display: flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.35rem 0.85rem;
    background: rgba(34,197,94,0.12);
    border: 1px solid rgba(34,197,94,0.25);
    border-radius: 99px;
    font-size: 0.72rem;
    color: #4ade80;
    font-weight: 600;
    letter-spacing: 0.05em;
    text-transform: uppercase;
}
.live-dot {
    width: 6px; height: 6px;
    border-radius: 50%;
    background: #4ade80;
    animation: livePulse 1.5s ease-in-out infinite;
}
@keyframes livePulse {
    0%, 100% { opacity: 1; transform: scale(1); }
    50%       { opacity: 0.5; transform: scale(0.7); }
}

/* ── Stats Grid ────────────────────────── */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(1, 1fr);
    gap: 1.25rem;
}
@media (min-width: 640px)  { .stats-grid { grid-template-columns: repeat(2, 1fr); } }
@media (min-width: 1024px) { .stats-grid { grid-template-columns: repeat(3, 1fr); } }
@media (min-width: 1280px) { .stats-grid { grid-template-columns: repeat(4, 1fr); } }

/* ── Stat Card ─────────────────────────── */
.stat-card {
    position: relative;
    border-radius: 20px;
    background: var(--bg-card);
    border: 1px solid var(--border);
    backdrop-filter: blur(20px);
    padding: 1.4rem 1.5rem 1.2rem;
    overflow: hidden;
    cursor: default;
    transition: transform 0.35s var(--ease-spring),
                border-color 0.3s var(--ease-smooth),
                box-shadow 0.35s var(--ease-smooth);
}
.stat-card:hover {
    transform: translateY(-6px) scale(1.015);
    border-color: var(--border-h);
    box-shadow: 0 24px 48px rgba(0,0,0,0.35), 0 0 0 1px var(--border-h);
}

/* Shine sweep on hover */
.stat-card__shine {
    position: absolute;
    top: 0; left: -100%;
    width: 60%; height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.04), transparent);
    transform: skewX(-20deg);
    transition: left 0.6s ease;
    pointer-events: none;
}
.stat-card:hover .stat-card__shine { left: 160%; }

/* Glow blob */
.stat-card__glow {
    position: absolute;
    top: -30px; right: -30px;
    width: 120px; height: 120px;
    border-radius: 50%;
    filter: blur(40px);
    opacity: 0.12;
    transition: opacity 0.4s, transform 0.4s;
}
.stat-card:hover .stat-card__glow { opacity: 0.25; transform: scale(1.3); }

.stat-card--blue    .stat-card__glow { background: var(--blue); }
.stat-card--emerald .stat-card__glow { background: var(--emerald); }
.stat-card--amber   .stat-card__glow { background: var(--amber); }
.stat-card--red     .stat-card__glow { background: var(--red); }
.stat-card--purple  .stat-card__glow { background: var(--purple); }
.stat-card--green   .stat-card__glow { background: var(--green); }

/* Top row */
.stat-card__top {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 1rem;
}
.stat-card__label {
    display: flex;
    align-items: center;
    gap: 0.6rem;
    font-family: var(--font-display);
    font-size: 0.72rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    color: var(--text-muted);
}

/* Icons */
.stat-icon {
    width: 34px; height: 34px;
    border-radius: 10px;
    display: grid; place-items: center;
    transition: transform 0.3s var(--ease-spring);
}
.stat-icon svg { width: 16px; height: 16px; }
.stat-card:hover .stat-icon { transform: rotate(-8deg) scale(1.15); }

.stat-icon--blue    { background: rgba(59,130,246,0.18);  color: #60a5fa; }
.stat-icon--emerald { background: rgba(16,185,129,0.18);  color: #34d399; }
.stat-icon--amber   { background: rgba(245,158,11,0.18);  color: #fbbf24; }
.stat-icon--red     { background: rgba(239,68,68,0.18);   color: #f87171; }
.stat-icon--purple  { background: rgba(168,85,247,0.18);  color: #c084fc; }
.stat-icon--green   { background: rgba(34,197,94,0.18);   color: #4ade80; }

.stat-card__badge-circle {
    width: 40px; height: 40px;
    border-radius: 50%;
    display: grid; place-items: center;
    transition: transform 0.35s var(--ease-spring);
    opacity: 0.7;
}
.stat-card__badge-circle svg { width: 18px; height: 18px; }
.stat-card:hover .stat-card__badge-circle { transform: scale(1.15) rotate(10deg); opacity: 1; }

/* Number */
.stat-card__number {
    font-family: var(--font-display);
    font-size: 2.6rem;
    font-weight: 800;
    color: var(--text-primary);
    line-height: 1;
    letter-spacing: -0.04em;
    margin-bottom: 0.5rem;
}
.stat-card__number--green { color: #4ade80; font-size: 2.2rem; }
.stat-card__number--green small { font-size: 1rem; font-weight: 500; opacity: 0.7; }
.stat-card__number--alert { color: #f87171; animation: alertPulse 1.8s ease-in-out infinite; }
@keyframes alertPulse {
    0%, 100% { opacity: 1; }
    50%       { opacity: 0.65; }
}

/* Meta */
.stat-card__meta {
    display: flex;
    align-items: center;
    gap: 0.4rem;
    font-size: 0.75rem;
    margin-bottom: 0.9rem;
    flex-wrap: wrap;
}
.meta-dot { width: 6px; height: 6px; border-radius: 50%; }
.meta-dot--green { background: var(--green); }
.meta-text  { color: var(--text-muted); }
.meta-highlight { color: #94a3b8; font-weight: 500; }
.docs-meta { gap: 0.5rem; }

.tag {
    padding: 0.2rem 0.55rem;
    border-radius: 99px;
    font-size: 0.68rem;
    font-weight: 500;
}
.tag--orange { background: rgba(251,146,60,0.15); color: #fb923c; border: 1px solid rgba(251,146,60,0.2); }
.tag--red    { background: rgba(239,68,68,0.15);  color: #f87171; border: 1px solid rgba(239,68,68,0.2); }

/* Progress bar */
.stat-card__bar {
    height: 3px;
    background: rgba(255,255,255,0.06);
    border-radius: 99px;
    overflow: hidden;
}
.stat-card__bar-fill {
    height: 100%;
    width: 0%;
    border-radius: 99px;
    animation: barGrow 1.2s var(--ease-smooth) forwards;
    animation-delay: var(--delay, 0.2s);
}
@keyframes barGrow {
    to { width: var(--bar-w, 0%); }
}

.stat-card--blue    .stat-card__bar-fill { background: linear-gradient(90deg, var(--blue), #93c5fd); }
.stat-card--emerald .stat-card__bar-fill { background: linear-gradient(90deg, var(--emerald), #6ee7b7); }
.stat-card--amber   .stat-card__bar-fill { background: linear-gradient(90deg, var(--amber), #fcd34d); }
.stat-card--red     .stat-card__bar-fill { background: linear-gradient(90deg, var(--red), #fca5a5); }
.stat-card--purple  .stat-card__bar-fill { background: linear-gradient(90deg, var(--purple), #d8b4fe); }

/* Alert card special */
.stat-card--alert {
    box-shadow: 0 0 0 1px rgba(239,68,68,0.25), 0 8px 32px rgba(239,68,68,0.12);
    animation: alertCardPulse 2.5s ease-in-out infinite;
}
@keyframes alertCardPulse {
    0%, 100% { box-shadow: 0 0 0 1px rgba(239,68,68,0.25), 0 8px 32px rgba(239,68,68,0.10); }
    50%       { box-shadow: 0 0 0 2px rgba(239,68,68,0.4),  0 8px 40px rgba(239,68,68,0.22); }
}

/* Alert ring badge */
.alert-ring {
    position: absolute;
    top: 12px; right: 12px;
    width: 12px; height: 12px;
}
.alert-ring__ping {
    position: absolute;
    inset: 0;
    border-radius: 50%;
    background: #ef4444;
    opacity: 0.7;
    animation: ping 1.4s cubic-bezier(0,0,0.2,1) infinite;
}
.alert-ring__dot {
    position: absolute;
    inset: 2px;
    border-radius: 50%;
    background: #ef4444;
}
@keyframes ping {
    75%, 100% { transform: scale(2.2); opacity: 0; }
}

/* Revenue bar */
.revenue-bar-track {
    position: relative;
    height: 6px;
    background: rgba(255,255,255,0.08);
    border-radius: 99px;
    overflow: hidden;
    margin-top: 0.75rem;
}
.revenue-bar-fill {
    position: absolute;
    top: 0; left: 0; bottom: 0;
    width: 0%;
    background: linear-gradient(90deg, #22c55e, #4ade80, #86efac);
    border-radius: 99px;
    animation: barGrow 1.4s var(--ease-smooth) forwards;
    --bar-w: 75%;
    animation-delay: 0.6s;
    box-shadow: 0 0 12px rgba(34,197,94,0.5);
}
.revenue-bar-label {
    position: absolute;
    right: 0; top: -20px;
    font-size: 0.65rem;
    color: #4ade80;
    font-weight: 600;
}

.growth-badge {
    display: flex;
    align-items: center;
    gap: 0.3rem;
    padding: 0.3rem 0.7rem;
    background: rgba(34,197,94,0.15);
    border: 1px solid rgba(34,197,94,0.25);
    border-radius: 99px;
    font-size: 0.72rem;
    color: #4ade80;
    font-weight: 700;
}

/* ── Bottom Panels ─────────────────────── */
.panels-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 1.25rem;
}
@media (min-width: 1024px) { .panels-grid { grid-template-columns: 1fr 1fr; } }

.panel {
    background: var(--bg-card);
    border: 1px solid var(--border);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    padding: 1.5rem;
    position: relative;
    overflow: hidden;
    transition: border-color 0.3s;
}
.panel:hover { border-color: var(--border-h); }
.panel::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 1px;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.12), transparent);
}

.panel__header {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1.25rem;
}
.panel__icon {
    width: 32px; height: 32px;
    border-radius: 9px;
    display: grid; place-items: center;
}
.panel__icon svg { width: 16px; height: 16px; }
.panel__icon--blue  { background: rgba(59,130,246,0.15); color: #60a5fa; }
.panel__icon--green { background: rgba(34,197,94,0.15);  color: #4ade80; }
.panel__title {
    font-family: var(--font-display);
    font-size: 0.95rem;
    font-weight: 700;
    color: var(--text-primary);
    letter-spacing: -0.01em;
}

/* Actions */
.actions-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0.75rem;
}
.action-btn {
    display: flex;
    align-items: center;
    gap: 0.6rem;
    padding: 0.75rem 1rem;
    background: rgba(255,255,255,0.04);
    border: 1px solid var(--border);
    border-radius: 12px;
    text-decoration: none;
    color: #cbd5e1;
    font-size: 0.8rem;
    font-weight: 400;
    transition: all 0.3s var(--ease-spring);
    position: relative;
    overflow: hidden;
}
.action-btn::after {
    content: '';
    position: absolute;
    inset: 0;
    background: rgba(255,255,255,0);
    transition: background 0.3s;
}
.action-btn:hover {
    transform: translateY(-2px) scale(1.03);
    border-color: var(--border-h);
    color: #f1f5f9;
    background: rgba(255,255,255,0.07);
    box-shadow: 0 8px 20px rgba(0,0,0,0.25);
}
.action-btn__icon {
    width: 28px; height: 28px;
    border-radius: 8px;
    display: grid; place-items: center;
    flex-shrink: 0;
    transition: transform 0.3s var(--ease-spring);
}
.action-btn__icon svg { width: 13px; height: 13px; }
.action-btn:hover .action-btn__icon { transform: scale(1.2) rotate(-5deg); }
.action-btn__icon--blue    { background: rgba(59,130,246,0.18);  color: #60a5fa; }
.action-btn__icon--emerald { background: rgba(16,185,129,0.18);  color: #34d399; }
.action-btn__icon--amber   { background: rgba(245,158,11,0.18);  color: #fbbf24; }
.action-btn__icon--purple  { background: rgba(168,85,247,0.18);  color: #c084fc; }

/* Status list */
.status-list { display: flex; flex-direction: column; gap: 0; }
.status-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 0;
    border-bottom: 1px solid rgba(255,255,255,0.05);
    transition: background 0.2s;
}
.status-row:last-of-type { border-bottom: none; }
.status-row--total { padding-top: 0.9rem; }
.status-row__label {
    display: flex;
    align-items: center;
    gap: 0.55rem;
    font-size: 0.82rem;
    color: var(--text-muted);
}
.status-row__label--total { color: var(--text-sub); font-weight: 500; }
.status-row__value {
    font-family: var(--font-display);
    font-size: 1rem;
    font-weight: 700;
    color: var(--text-primary);
}
.status-row__value--green { color: #4ade80; }

.status-dot {
    width: 8px; height: 8px;
    border-radius: 50%;
    display: inline-block;
}
.status-dot--green { background: #22c55e; box-shadow: 0 0 6px rgba(34,197,94,0.6); }
.status-dot--amber { background: #f59e0b; box-shadow: 0 0 6px rgba(245,158,11,0.6); }
.status-dot--blue  { background: #3b82f6; box-shadow: 0 0 6px rgba(59,130,246,0.6); }

.occupation-track {
    height: 4px;
    background: rgba(255,255,255,0.06);
    border-radius: 99px;
    overflow: hidden;
    margin-top: 0.75rem;
}
.occupation-fill {
    height: 100%;
    width: 0%;
    background: linear-gradient(90deg, #22c55e, #4ade80);
    border-radius: 99px;
    animation: barGrow 1.4s var(--ease-smooth) 0.6s forwards;
    --bar-w: var(--occ, 0%);
    box-shadow: 0 0 8px rgba(34,197,94,0.4);
}

/* ── Reveal Animations ─────────────────── */
.reveal-down {
    opacity: 0;
    transform: translateY(-28px);
    animation: revealDown 0.75s var(--ease-spring) forwards;
    animation-delay: var(--delay, 0s);
}
.reveal-up {
    opacity: 0;
    transform: translateY(28px);
    animation: revealUp 0.7s var(--ease-spring) forwards;
    animation-delay: var(--delay, 0.1s);
}
@keyframes revealDown {
    to { opacity: 1; transform: translateY(0); }
}
@keyframes revealUp {
    to { opacity: 1; transform: translateY(0); }
}
</style>

{{-- ══════════════════════════════════════════ --}}
{{-- COUNTER ANIMATION SCRIPT                    --}}
{{-- ══════════════════════════════════════════ --}}
<script>
document.addEventListener('DOMContentLoaded', () => {
    const counters = document.querySelectorAll('.counter');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (!entry.isIntersecting) return;
            const el = entry.target;
            const target = parseInt(el.dataset.target, 10) || 0;
            const duration = 1400;
            const start = performance.now();
            const animate = (now) => {
                const elapsed = now - start;
                const progress = Math.min(elapsed / duration, 1);
                // easeOutExpo
                const eased = progress === 1 ? 1 : 1 - Math.pow(2, -10 * progress);
                el.textContent = Math.floor(eased * target).toLocaleString('fr-FR');
                if (progress < 1) requestAnimationFrame(animate);
            };
            requestAnimationFrame(animate);
            observer.unobserve(el);
        });
    }, { threshold: 0.2 });
    counters.forEach(c => observer.observe(c));
});
</script>

@endsection
