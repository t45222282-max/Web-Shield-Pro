---
document: 05 — Layout & Navigation
project: Web Shield
version: 1.0
status: Draft
audience: Developers
---

# 🏗️ الهيكل والتنقل (Layout & Navigation)

> هذا الملف يصف كيف تُجمع المكونات في صفحة كاملة. يبني فوق `core.php` الموجود.

---

## 1. الهيكل العام (App Shell)

```
┌────────────────────────────────────────────────────────┐
│                      TOPBAR                            │  ← 56px
├──────────┬─────────────────────────────────────────────┤
│          │                                             │
│          │                                             │
│ SIDEBAR  │              MAIN CONTENT                   │
│  256px   │                                             │
│          │                                             │
│          │                                             │
├──────────┴─────────────────────────────────────────────┤
│                      FOOTER (اختياري)                  │  ← 40px
└────────────────────────────────────────────────────────┘
```

### القياسات الموحدة
| العنصر | الديسكتوب | التابلت | الجوال |
|--------|----------|---------|-------|
| Sidebar Width (موسع) | 256px | 240px | full screen overlay |
| Sidebar Width (مطوي) | 64px | 64px | hidden |
| Topbar Height | 56px | 56px | 56px |
| Content Max-Width | 1600px | - | - |
| Content Padding | 24px | 16px | 12px |

---

## 2. الـ Sidebar — تفصيل دقيق

### 2.1 المناطق (Zones)

```
┌──────────────────────┐
│ [LOGO]   Web Shield  │  ← Brand Zone (64px)
├──────────────────────┤
│ ─── العامة ───        │  ← Section Label (12px overline)
│ 🏠  لوحة المراقبة    │
│ 📊  الإحصائيات        │
│                      │
│ ─── الحماية ───       │
│ 🛡️  SQL Injection    │
│ 🐛  Bad Bots         │
│ 📧  Spam             │
│ 🔀  Proxy            │  ← Active item: نيون border + خلفية
│                      │
│ ─── الإدارة ───       │
│ 🚫  القائمة السوداء   │
│ ✅  القائمة البيضاء    │
│ ⚙️  الإعدادات         │
├──────────────────────┤
│ [● admin] أحمد محمد   │  ← User Zone (56px)
│           Online      │
└──────────────────────┘
```

### 2.2 السلوك

| السيناريو | السلوك |
|---------|--------|
| ديسكتوب (≥ 1200px) | موسع افتراضياً، يمكن طيّه يدوياً |
| لابتوب (992-1199) | موسع افتراضياً |
| تابلت (768-991) | مطوي افتراضياً، يتمدد عند Hover |
| جوال (< 768) | مخفي، يفتح كـ Drawer من اليمين (RTL) |

التطوي يُحفظ في `localStorage` لذكرى المستخدم.

### 2.3 الـ Active State — تفصيل التميز

البند النشط في الـ Sidebar يجب أن يكون **مميزاً جداً**:

```css
.shield-sidebar__item.is-active {
  background: linear-gradient(
    90deg,
    rgba(0, 184, 230, 0.10) 0%,
    rgba(0, 184, 230, 0.02) 100%
  );
  color: var(--text-primary);
}
.shield-sidebar__item.is-active::before {
  /* خط نيون عمودي على الجانب — في RTL على اليمين */
  content: '';
  position: absolute;
  inset-inline-start: 0;
  top: 8px; bottom: 8px;
  width: 3px;
  background: var(--color-brand-500);
  border-radius: 0 var(--radius-sm) var(--radius-sm) 0;
  box-shadow: var(--glow-brand);
}
.shield-sidebar__item.is-active .icon {
  color: var(--color-brand-500);
}
```

### 2.4 Status Dots بجانب الوحدات

كل وحدة حماية لها نقطة حالة (مفعلة/معطلة) — بصرياً تعطي إحساس **"غرفة التحكم"**:

```html
<a class="shield-sidebar__item is-active">
  <i data-lucide="database" class="icon icon-md"></i>
  <span>SQL Injection</span>
  <span class="status-dot status-dot--on" title="مفعل"></span>
</a>
```

```css
.status-dot {
  width: 6px; height: 6px;
  border-radius: 50%;
  margin-inline-start: auto;
}
.status-dot--on { background: var(--color-success); box-shadow: 0 0 6px var(--color-success); }
.status-dot--off { background: var(--text-disabled); }
.status-dot--alert { background: var(--color-warning); animation: shield-pulse-fast 1s infinite; }
```

### 2.5 Sidebar مطوي — أيقونات فقط

```css
.shield-sidebar.is-collapsed { width: 64px; }
.shield-sidebar.is-collapsed .shield-sidebar__label,
.shield-sidebar.is-collapsed .shield-sidebar__section-title { display: none; }
.shield-sidebar.is-collapsed .shield-sidebar__item {
  justify-content: center;
}
/* Tooltip عند Hover */
.shield-sidebar.is-collapsed .shield-sidebar__item:hover::after {
  content: attr(data-label);
  position: absolute;
  inset-inline-start: calc(100% + 8px);
  background: var(--bg-surface-3);
  padding: 4px 8px;
  border-radius: var(--radius-sm);
  white-space: nowrap;
  font-size: var(--text-xs);
  z-index: var(--z-tooltip);
}
```

---

## 3. الـ Topbar

### 3.1 التشريح (RTL)

```
┌──────────────────────────────────────────────────────────────────┐
│ [☰] Page Title › Subpage     [🔍 K] | [🔔 3] [🌓] [⛛ admin ▾]  │
└──────────────────────────────────────────────────────────────────┘
   ↑              ↑                ↑          ↑      ↑    ↑
   |              |                |          |      |    └─ User menu
   |              |                |          |      └────── Theme toggle
   |              |                |          └─────────────  Notifications
   |              |                └──────────────────────── Command palette
   |              └────────────────────────────────────────── Breadcrumb
   └───────────────────────────────────────────────────────── Sidebar toggle
```

### 3.2 المتطلبات
- **ارتفاع ثابت 56px**.
- **خلفية:** `--bg-surface-1` مع `border-bottom: 1px solid var(--border-subtle)`.
- **مثبت** (`position: sticky; top: 0`).
- **Backdrop blur خفيف** عند التمرير لإحساس "Glass":
```css
.shield-topbar.is-scrolled {
  background: rgba(17, 23, 38, 0.85);
  backdrop-filter: saturate(180%) blur(16px);
}
```

### 3.3 Breadcrumb — مهم للسياق

```html
<nav class="shield-breadcrumb">
  <a href="/dashboard.php">المراقبة</a>
  <i data-lucide="chevron-left" class="icon icon-xs"></i>
  <span aria-current="page">SQL Injection</span>
</nav>
```

```css
.shield-breadcrumb {
  display: flex; align-items: center; gap: var(--space-2);
  font-size: var(--text-sm);
  color: var(--text-tertiary);
}
.shield-breadcrumb a { color: var(--text-secondary); }
.shield-breadcrumb a:hover { color: var(--text-primary); }
.shield-breadcrumb [aria-current] { color: var(--text-primary); }
```

### 3.4 Command Palette Trigger

زر بحث مميز بشكل (`⌘K` أو `Ctrl+K`):

```html
<button class="shield-cmdk-trigger">
  <i data-lucide="search" class="icon icon-sm"></i>
  <span>بحث سريع...</span>
  <kbd>Ctrl K</kbd>
</button>
```

```css
.shield-cmdk-trigger {
  display: flex; align-items: center; gap: var(--space-2);
  height: 32px;
  padding: 0 var(--space-3);
  background: var(--bg-surface-2);
  border: 1px solid var(--border-subtle);
  border-radius: var(--radius-md);
  color: var(--text-tertiary);
  font-size: var(--text-sm);
  cursor: pointer;
  min-width: 240px;
  transition: var(--transition-color);
}
.shield-cmdk-trigger:hover {
  border-color: var(--border-default);
  color: var(--text-secondary);
}
.shield-cmdk-trigger kbd {
  margin-inline-start: auto;
  padding: 1px 6px;
  background: var(--bg-surface-3);
  border: 1px solid var(--border-subtle);
  border-radius: var(--radius-xs);
  font-family: var(--font-mono);
  font-size: var(--text-2xs);
  color: var(--text-secondary);
}
```

---

## 4. منطقة المحتوى (Main Content)

### 4.1 الترويسة (Page Header)

كل صفحة تبدأ بترويسة موحدة:

```html
<header class="page-header">
  <div class="page-header__main">
    <h1 class="txt-h1">SQL Injection Protection</h1>
    <p class="txt-body-sm txt-secondary">
      مراقبة وحظر محاولات حقن قواعد البيانات في الوقت الفعلي.
    </p>
  </div>
  <div class="page-header__actions">
    <button class="btn-shield-secondary">
      <i data-lucide="download" class="icon icon-sm"></i>
      تصدير
    </button>
    <button class="btn-shield-primary">
      <i data-lucide="plus" class="icon icon-sm"></i>
      قاعدة جديدة
    </button>
  </div>
</header>
```

```css
.page-header {
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  gap: var(--space-4);
  padding: var(--space-6) 0;
  margin-bottom: var(--space-6);
  border-bottom: 1px solid var(--border-subtle);
}
.page-header__actions { display: flex; gap: var(--space-2); }
```

### 4.2 شبكة المحتوى (Content Grid)

```html
<div class="content-grid">
  <!-- صف KPIs (4 أعمدة) -->
  <section class="grid grid-cols-4 gap-4">
    <div class="kpi-card">...</div>
    <div class="kpi-card">...</div>
    <div class="kpi-card">...</div>
    <div class="kpi-card">...</div>
  </section>

  <!-- صف Charts (2 أعمدة) -->
  <section class="grid grid-cols-3 gap-4">
    <div class="shield-card grid-col-span-2">
      <!-- chart -->
    </div>
    <div class="shield-card">
      <!-- top countries -->
    </div>
  </section>

  <!-- جدول كامل العرض -->
  <section class="shield-table-wrapper">
    ...
  </section>
</div>
```

```css
.grid { display: grid; }
.grid-cols-2 { grid-template-columns: repeat(2, 1fr); }
.grid-cols-3 { grid-template-columns: repeat(3, 1fr); }
.grid-cols-4 { grid-template-columns: repeat(4, 1fr); }
.gap-4 { gap: var(--space-4); }
.grid-col-span-2 { grid-column: span 2; }

@media (max-width: 1199px) {
  .grid-cols-4 { grid-template-columns: repeat(2, 1fr); }
  .grid-cols-3 { grid-template-columns: 1fr; }
  .grid-col-span-2 { grid-column: span 1; }
}
@media (max-width: 767px) {
  .grid-cols-2, .grid-cols-3, .grid-cols-4 { grid-template-columns: 1fr; }
}
```

---

## 5. الفلاتر (Filter Bar)

في صفحات السجلات (Logs)، الفلاتر مهمة جداً:

### 5.1 الموضع
شريط أفقي أعلى الجدول، أو **Drawer جانبي** للفلاتر المتقدمة.

### 5.2 المكونات
- **Date Range Picker** (آخر 24س / 7 أيام / 30 يوم / مخصص).
- **Multi-select** (الدولة، النوع، الخطورة).
- **Search** (IP, URL, User-Agent).
- **Severity Toggle** (Critical / High / Medium / Low).
- **Clear All** — زر مسح كل الفلاتر.

### 5.3 Active Filters Pills

عند تفعيل فلاتر، تظهر كـ "chips" أسفل الشريط:

```html
<div class="active-filters">
  <span class="filter-chip">
    آخر 24 ساعة
    <button><i data-lucide="x" class="icon icon-xs"></i></button>
  </span>
  <span class="filter-chip">
    الخطورة: حرج، عالي
    <button><i data-lucide="x" class="icon icon-xs"></i></button>
  </span>
  <button class="filter-chip filter-chip--clear">مسح الكل</button>
</div>
```

---

## 6. الصفحة الرئيسية (Dashboard) — تخطيط مقترح

```
┌─────────────────────────────────────────────────────────────────┐
│ Page Header: لوحة المراقبة | آخر تحديث: قبل 12 ثانية [● Live]  │
├─────────────────────────────────────────────────────────────────┤
│ [KPI 1]    [KPI 2]    [KPI 3]    [KPI 4]                       │
│ Protected  Threats    Blocked    Active Rules                   │
├─────────────────────────────────────────────────────────────────┤
│ ┌───────────────────────────────┐ ┌──────────────────────────┐ │
│ │  Threats Timeline (24h)       │ │  Top Countries           │ │
│ │  Area Chart                   │ │  Bar List                │ │
│ │                               │ │                          │ │
│ └───────────────────────────────┘ └──────────────────────────┘ │
├─────────────────────────────────────────────────────────────────┤
│ ┌──────────────────┐ ┌──────────────────┐ ┌──────────────────┐│
│ │ Threat Types     │ │ Top Attacking IPs│ │ Recent Activity  ││
│ │ Donut + Legend   │ │ List with bars   │ │ Timeline         ││
│ └──────────────────┘ └──────────────────┘ └──────────────────┘│
├─────────────────────────────────────────────────────────────────┤
│  Live Threat Stream                                             │
│  [جدول مع 10 أحدث الأحداث، يحدّث تلقائياً]                       │
└─────────────────────────────────────────────────────────────────┘
```

---

## 7. صفحة سجلات (List Page) — تخطيط مقترح

```
┌─────────────────────────────────────────────────────────────────┐
│ Page Header                                                     │
├─────────────────────────────────────────────────────────────────┤
│ [KPI mini 1]  [KPI mini 2]  [KPI mini 3]  [KPI mini 4]         │
├─────────────────────────────────────────────────────────────────┤
│ Filter Bar [البحث] [التاريخ] [الدولة] [الخطورة] [⚙️ متقدم]      │
├─────────────────────────────────────────────────────────────────┤
│ Active Filters: [آخر 24س ×] [الخطورة: حرج ×]    [مسح الكل]      │
├─────────────────────────────────────────────────────────────────┤
│ Toolbar: عرض 1-25 من 1,247       [تحديث] [تصدير CSV] [⚙ أعمدة] │
├─────────────────────────────────────────────────────────────────┤
│ Table (Sticky Header)                                           │
│ ─────────────────────────────────────────                       │
│ # | IP | Country | Type | Severity | Time | Actions             │
│ ─────────────────────────────────────────                       │
│ ...                                                             │
├─────────────────────────────────────────────────────────────────┤
│ Pagination: [<] 1 2 3 4 5 [>]                  [25 ▾] لكل صفحة │
└─────────────────────────────────────────────────────────────────┘
```

---

## 8. شاشة Login — لمسة استقبال

شاشة تسجيل الدخول هي **الانطباع الأول**. يجب أن تكون مؤثرة:

```
┌─────────────────────────────────────────────────────────────────┐
│                  [خلفية: شبكة نقاط خفيفة + تدرج]                  │
│                                                                 │
│              ┌─────────────────────────────────┐                │
│              │   [LOGO 64px مع توهج خفيف]      │                │
│              │                                 │                │
│              │       Web Shield                │                │
│              │   تسجيل دخول مركز التحكم       │                │
│              │                                 │                │
│              │   ┌─────────────────────────┐   │                │
│              │   │ اسم المستخدم            │   │                │
│              │   └─────────────────────────┘   │                │
│              │   ┌─────────────────────────┐   │                │
│              │   │ كلمة المرور             │   │                │
│              │   └─────────────────────────┘   │                │
│              │   [ ] تذكرني                    │                │
│              │   ┌─────────────────────────┐   │                │
│              │   │      دخول →             │   │                │
│              │   └─────────────────────────┘   │                │
│              │                                 │                │
│              └─────────────────────────────────┘                │
│                                                                 │
│            v1.0 · Secured by Web Shield Engine                  │
└─────────────────────────────────────────────────────────────────┘
```

تفاصيل بصرية:
- **خلفية:** نمط شبكي SVG خفيف + تدرج radial من المركز.
- **الكرت:** خلفية `--bg-surface-1` بشفافية 80% + `backdrop-filter: blur(20px)`.
- **الشعار:** يتنفس بانيميشن 3s scale لطيف.
- **الزر:** نيون كامل + glow.

---

## 9. التجاوب (Responsive Behavior)

### قواعد عامة:
1. **Mobile-first في الكود الجديد**، حتى لو AdminLTE desktop-first.
2. الـ Sidebar **تختفي** على الجوال وتُفتح كـ drawer.
3. الجداول الـ wide **تتحول** إلى cards على الجوال (كل صف = كرت).
4. الـ KPIs الأربعة **تصبح 2×2** على التابلت، **عمود واحد** على الجوال.
5. الفلاتر **تنطوي** خلف زر "Filters" على الجوال.

### مثال: تحويل جدول إلى كروت على الجوال

```css
@media (max-width: 767px) {
  .shield-table thead { display: none; }
  .shield-table, .shield-table tbody, .shield-table tr, .shield-table td {
    display: block; width: 100%;
  }
  .shield-table tr {
    background: var(--bg-surface-1);
    border: 1px solid var(--border-subtle);
    border-radius: var(--radius-md);
    margin-bottom: var(--space-3);
    padding: var(--space-3);
  }
  .shield-table td {
    display: flex;
    justify-content: space-between;
    height: auto;
    padding: var(--space-2) 0;
    border: none;
  }
  .shield-table td::before {
    content: attr(data-label);
    color: var(--text-tertiary);
    font-size: var(--text-xs);
    text-transform: uppercase;
  }
}
```

---

## 📎 الخطوة التالية

اقرأ الآن: [`06-data-visualization.md`](./06-data-visualization.md) — الرسوم البيانية.
