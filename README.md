# Work Order Platform — Dual Screen POC

A Laravel + Livewire proof of concept that syncs navigation between browser tabs using the [BroadcastChannel API](https://developer.mozilla.org/en-US/docs/Web/API/BroadcastChannel). Demonstrates the "linked views" pattern — like a desktop app with multiple windows that stay in sync.

**Demo:** Open Work Orders in one tab and Documents in another. Select a work order → the documents tab instantly shows that work order's files.

## Goals

This POC answers the question: **Can a web app replicate the multi-window experience of a desktop application?**

Many office workers — especially in compliance, logistics, and operations — rely on desktop software that supports linked views across multiple monitors. One screen shows the work order, another shows related documents. Switching context in one window updates the other automatically. When these teams migrate to web-based tools, they lose this capability because browser tabs are independent by default.

This POC proves that the BroadcastChannel API bridges that gap with zero server infrastructure. Livewire handles all persistence and is the source of truth. BroadcastChannel just coordinates navigation state between tabs in the same browser.

## Potential Usage

This pattern could be applied to any web application where users work across multiple screens:

- **Work order + documents** (this demo) — compliance staff reviewing work orders on one screen, related documents on another
- **Client profile + activity log** — customer service reps seeing account details and recent activity side by side
- **Invoice list + payment details** — accounting staff processing invoices with supporting info visible simultaneously
- **Dispatch board + driver details** — logistics coordinators monitoring routes while reviewing driver assignments
- **Any master-detail workflow** where the "detail" view lives in a separate window/monitor

The key constraint: BroadcastChannel is **same-browser, same-origin only**. It's not cross-device sync — it's multi-monitor sync for a single user. For cross-device, you'd layer WebSockets or server-sent events on top.

## How It Works

Two browser tabs, two different Livewire components, one shared BroadcastChannel:

1. **Tab A — Work Orders (`/`):** Split-view with work order list + detail panel. When you click a work order, it broadcasts `work-order-selected` on the channel.
2. **Tab B — Documents (`/documents`):** Listens for `work-order-selected` messages and calls `$wire.selectWorkOrder(id)` to show that work order's documents.

No WebSockets, no Pusher, no server-side broadcasting. BroadcastChannel is browser-native and same-origin only — perfect for same-user tab coordination.

## Local Development

### Prerequisites

- PHP 8.2+
- Composer
- SQLite

### Setup

```bash
git clone https://github.com/Consultran/laravel-poc-dual-screens.git
cd laravel-poc-dual-screens
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate --seed
```

### Run

```bash
php artisan serve
```

1. Open [http://localhost:8000](http://localhost:8000) — this is your **Work Orders** tab
2. Open [http://localhost:8000/documents](http://localhost:8000/documents) in a **second tab** — this is your **Documents** tab
3. Click a work order in Tab A → Tab B shows its documents instantly

> **Tip:** Use `localhost:8000` for both tabs. Don't mix `localhost` and `127.0.0.1` — they're different origins and BroadcastChannel won't sync between them.

### Sample Data

The seeder creates 5 work orders with 15 total documents:

| Work Order | Customer | Status | Docs |
|------------|----------|--------|------|
| WO-1001 | Smith Transport | In Progress | 3 |
| WO-1002 | Jones Logistics | Pending | 3 |
| WO-1003 | Delta Freight | Completed | 4 |
| WO-1004 | Apex Carriers | In Progress | 3 |
| WO-1005 | Mountain View Trucking | Cancelled | 2 |

## Tech Stack

- Laravel 13
- Livewire v4
- SQLite
- Tailwind CSS (CDN)
- BroadcastChannel API (browser-native)
