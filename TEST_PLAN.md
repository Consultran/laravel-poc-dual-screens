# Manual Test Plan — Work Order Dual Screen POC

## Setup

```bash
php artisan migrate:fresh --seed
php artisan serve
```

Open two browser tabs side by side:
- **Tab A:** http://localhost:8000 (Work Orders)
- **Tab B:** http://localhost:8000/documents (Documents)

> Important: Use `localhost:8000` for BOTH tabs. Don't mix `localhost` and `127.0.0.1`.

---

## Pre-flight Checks

- [ ] **P1. Work Orders loads** — Tab A shows nav bar + 5 work orders in left panel + empty state on right ("Select a work order to view details")
- [ ] **P2. Documents loads** — Tab B shows nav bar + empty state ("No work order selected")
- [ ] **P3. Nav bar** — Both tabs show "WorkOrderSync" logo with "Work Orders" and "Documents" links. Active page is highlighted.

---

## Test 1: Select a Work Order (Tab A → Tab B)

1. In **Tab A**, click **WO-1001** (Smith Transport)
2. Expected in **Tab A**:
   - [ ] WO-1001 is highlighted in the left panel (blue left border)
   - [ ] Right panel shows: "WO-1001", "In progress" badge, "Smith Transport"
   - [ ] Description: "Annual compliance review for fleet units..."
   - [ ] Due date: Apr 15, 2026
   - [ ] Documents: 3 attached
3. Expected in **Tab B** (within ~1 second):
   - [ ] Header shows "WO-1001 · Smith Transport" with "3 documents"
   - [ ] Three documents listed: Insurance Certificate, Vehicle Registration, Safety Inspection Report
   - [ ] Each document shows filename and type badge (Certificate, Registration, Inspection)
   - [ ] "Last synced" shows "Synced @ [time]"

---

## Test 2: Switch to a Different Work Order

1. In **Tab A**, click **WO-1003** (Delta Freight)
2. Expected in **Tab A**:
   - [ ] WO-1003 is now highlighted, WO-1001 is not
   - [ ] Right panel shows Delta Freight details, status "Completed"
   - [ ] Documents: 4 attached
3. Expected in **Tab B**:
   - [ ] Header switches to "WO-1003 · Delta Freight" with "4 documents"
   - [ ] Four documents: Cab Card, Title Copy, Lease Agreement, Proof of Insurance
   - [ ] "Last synced" time updates

---

## Test 3: All Work Orders

Click through each work order and verify Tab B updates:

| Work Order | Customer | Expected Docs |
|------------|----------|---------------|
| WO-1001 | Smith Transport | Insurance Certificate, Vehicle Registration, Safety Inspection Report |
| WO-1002 | Jones Logistics | MC Application, BOC-3 Filing, Insurance Certificate |
| WO-1003 | Delta Freight | Cab Card, Title Copy, Lease Agreement, Proof of Insurance |
| WO-1004 | Apex Carriers | Mileage Summary, Fuel Receipts, Prior Quarter Filing |
| WO-1005 | Mountain View Trucking | Random Selection Letter, MRO Report |

- [ ] All 5 work orders sync correctly to Tab B

---

## Test 4: Three Tabs

1. Open a **Tab C** at http://localhost:8000 (another Work Orders tab)
2. In **Tab A**, click **WO-1002**
3. Expected:
   - [ ] **Tab B** (Documents) shows WO-1002's documents
   - [ ] **Tab C** (Work Orders) highlights WO-1002 and shows its details

---

## Test 5: Documents Tab Opens Fresh

1. Close Tab B
2. Open a new tab at http://localhost:8000/documents
3. Expected:
   - [ ] Shows "No work order selected" empty state
   - [ ] "Last synced: waiting for selection..."
4. Click WO-1004 in Tab A
5. Expected:
   - [ ] New documents tab updates to show WO-1004's documents

---

## What "Pass" Looks Like

All checkboxes checked. The key experience: **selecting a work order in one tab instantly updates the documents tab** — like a desktop app with linked windows. No page reloads, no manual refresh, no console errors.
