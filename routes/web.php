<?php

use Illuminate\Support\Facades\Route;
use Jacofda\Klaxon\Http\Controllers\AssemblyController;
use Jacofda\Klaxon\Http\Controllers\CalendarController;
use Jacofda\Klaxon\Http\Controllers\CheckController;
use Jacofda\Klaxon\Http\Controllers\CompanyController;
use Jacofda\Klaxon\Http\Controllers\ContactController;
use Jacofda\Klaxon\Http\Controllers\CostController;
use Jacofda\Klaxon\Http\Controllers\DdtController;
use Jacofda\Klaxon\Http\Controllers\EditorController;
use Jacofda\Klaxon\Http\Controllers\EventController;
use Jacofda\Klaxon\Http\Controllers\ExpenseController;
use Jacofda\Klaxon\Http\Controllers\ExportController;
use Jacofda\Klaxon\Http\Controllers\GeneralController;
use Jacofda\Klaxon\Http\Controllers\ImportController;
use Jacofda\Klaxon\Http\Controllers\InvoiceController;
use Jacofda\Klaxon\Http\Controllers\LogController;
use Jacofda\Klaxon\Http\Controllers\MediaController;
use Jacofda\Klaxon\Http\Controllers\NewsletterController;
use Jacofda\Klaxon\Http\Controllers\NewsletterListController;
use Jacofda\Klaxon\Http\Controllers\NotificationController;
use Jacofda\Klaxon\Http\Controllers\OrderErpController;
use Jacofda\Klaxon\Http\Controllers\PagesController;
use Jacofda\Klaxon\Http\Controllers\PdfController;
use Jacofda\Klaxon\Http\Controllers\ProductController;
use Jacofda\Klaxon\Http\Controllers\ProductionController;
use Jacofda\Klaxon\Http\Controllers\PurchaseController;
use Jacofda\Klaxon\Http\Controllers\ReportController;
use Jacofda\Klaxon\Http\Controllers\RoleController;
use Jacofda\Klaxon\Http\Controllers\SettingController;
use Jacofda\Klaxon\Http\Controllers\ShippingController;
use Jacofda\Klaxon\Http\Controllers\StatController;
use Jacofda\Klaxon\Http\Controllers\StoreController;
use Jacofda\Klaxon\Http\Controllers\UserController;
use Jacofda\Klaxon\Http\Controllers\TemplateController;
use Jacofda\Klaxon\Http\Controllers\WorkController;




Route::get('calendars', [CalendarController::class, 'index'])->name('calendars.index');
Route::post('calendars', [CalendarController::class, 'store'])->name('calendars.store');
Route::get('calendars/overlayed', [CalendarController::class, 'overlayed'])->name('calendars.overlayed');
Route::get('calendars/create', [CalendarController::class, 'create'])->name('calendars.create');
Route::get('calendars/{calendar}', [CalendarController::class, 'show'])->name('calendars.show');
Route::patch('calendars/{calendar}', [CalendarController::class, 'update'])->name('calendars.update');
Route::delete('calendars/{calendar}', [CalendarController::class, 'destroy'])->name('calendars.destroy');
Route::get('calendars/{calendar}/edit', [CalendarController::class, 'edit'])->name('calendars.edit');
Route::get('api/calendars/{calendar_id}/events', [EventController::class, 'calendarEvent'])->name('api.calendar.events');

Route::resource('companies', CompanyController::class);
Route::get('api/companies/{company}', [CompanyController::class, 'checkNation'])->name('api.company.checkNation');
Route::get('api/companies/{company}/notes', [CompanyController::class, 'getNote'])->name('api.company.notes');
Route::post('api/companies/{company}/notes/add', [CompanyController::class, 'addNote'])->name('api.company.addNotes');
Route::get('api/ta/companies', [CompanyController::class, 'taindex'])->name('api.ta.companies');

Route::post('contacts/make-company', [ContactController::class, 'makeCompany'])->name('contacts.makeCompany');
Route::post('contacts/make-user', [ContactController::class, 'makeUser'])->name('contacts.makeUser');
Route::post('contacts-validate-file', [ContactController::class, 'validateFile'])->name('csv.contacts.validate');
Route::resource('contacts', ContactController::class);
Route::get('api/ta/contacts', [ContactController::class, 'taindex'])->name('api.ta.contacts');

Route::get('costs', [CostController::class, 'index'])->name('costs.index');
Route::resource('costs', CostController::class);
Route::post('api/costs/saldato', [CostController::class, 'toggleSaldato'])->name('api.costs.toggleSaldato');
Route::get('api/ta/costs', [CostController::class, 'taindex'])->name('api.ta.costs');

Route::get('template-builder', [EditorController::class, 'editor']);
Route::get('template-builder/{id}', [EditorController::class, 'editorWithTemplate']);
Route::get('create-template-builder', [EditorController::class, 'createTemplateBuilder'] );
Route::get('edit-template-builder/{id}', [EditorController::class, 'editTemplateBuilder'] );
Route::get('editor/elements/{slug}', [EditorController::class, 'show']);
Route::get('editor/images', [EditorController::class, 'images'])->name('editor.images');
Route::post('editor/upload', [EditorController::class, 'upload'])->name('editor.upload');
Route::post('editor/delete', [EditorController::class, 'delete'])->name('editor.delete');

Route::resource('events', EventController::class);
Route::get('api/events', [EventController::class, 'defaultUserEvent'])->name('api.user.defaultEvents');
Route::get('api/events/{user_id}', [EventController::class, 'userEvent'])->name('api.user.events');
Route::post('api/events/{event}/done', [EventController::class, 'markAsDone'])->name('api.events.done');

Route::get('expenses/modify', [ExpenseController::class, 'modifyCategories'])->name('expenses.categories.edit');
Route::resource('expenses', ExpenseController::class);

Route::get('exports/{model}', [ExportController::class, 'export'])->name('csv.export');
Route::post('imports/peek', [ImportController::class, 'peek'])->name('csv.import.peek');
Route::get('imports/{model}', [ImportController::class, 'importForm'])->name('csv.import.form');
Route::post('imports/{model}', [ImportController::class, 'importUpload'])->name('csv.import.upload');

Route::get('invoices/{invoice}/export', [InvoiceController::class, 'export'])->name('invoices.export');
Route::resource('invoices', InvoiceController::class);
Route::get('api/invoices/export', [InvoiceController::class, 'exportXmlInZip'])->name('api.invoices.export');
Route::get('api/invoices/import', [InvoiceController::class, 'import'])->name('api.invoices.importForm');
Route::post('api/invoices/check', [InvoiceController::class, 'checkUnique'])->name('api.invoices.check');
Route::post('api/invoices/import', [InvoiceController::class, 'importProcess'])->name('api.invoices.import');
Route::post('api/invoices/saldato', [InvoiceController::class, 'toggleSaldato'])->name('api.invoices.toggleSaldato');
Route::get('api/invoices/{invoice}/check', [InvoiceController::class, 'checkBeforeFe'])->name('api.invoices.checkBeforeFe');
Route::post('api/invoices/{invoice}/send-fe', [InvoiceController::class, 'sendFe'])->name('api.invoices.sendFe');
Route::post('api/invoices/{invoice}/duplicate', [InvoiceController::class, 'duplicate'])->name('api.invoices.duplicate');
Route::get('api/invoices/{type}', [InvoiceController::class, 'getNumberFromType'])->name('api.invoices.getNumber');

Route::resource('newsletters', NewsletterController::class);
Route::get('newsletters/{newsletter}/send-test', [NewsletterController::class, 'test'])->name('newsletters.formTest');
Route::post('newsletters/{newsletter}/send-test', [NewsletterController::class, 'sendTest'])->name('newsletters.sendTest');
Route::get('newsletters/{newsletter}/send', [NewsletterController::class, 'send'])->name('newsletters.form');
Route::post('newsletters/{newsletter}/send', [NewsletterController::class, 'sendOfficial'])->name('newsletters.send');

Route::get('newsletters/{newsletter}/reports', [ReportController::class, 'index'])->name('reports.newsletter.index');
Route::get('newsletters/{newsletter}/reports/aperte', [ReportController::class, 'showOpen'])->name('reports.newsletter.opened');
Route::get('newsletters/{newsletter}/reports/errore', [ReportController::class, 'showErrore'])->name('reports.newsletter.failed');
Route::get('newsletters/{newsletter}/reports/unsubscribed', [ReportController::class, 'showUnsubscribed'])->name('reports.newsletter.unsubscribed');
Route::get('newsletters/{newsletter}/reports/{report}', [ReportController::class, 'show'])->name('reports.newsletter.show');

Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
Route::get('notifications/{notification}', [NotificationController::class, 'show'])->name('notifications.show');
Route::post('notifications/{notification}', [NotificationController::class, 'markAsRead'])->name('notifications.read');
Route::delete('notifications/{notification}', [NotificationController::class, 'destroy'])->name('notifications.destroy');

Route::get('/', [PagesController::class, 'home'])->name('home');
Route::post('logout', [PagesController::class, 'logout'])->name('logout');

Route::get('lists', [NewsletterListController::class, 'index'])->name('lists.index');
Route::post('lists', [NewsletterListController::class, 'store'])->name('lists.store');
Route::get('lists/create', [NewsletterListController::class, 'create'])->name('lists.create');
Route::get('lists/{list}', [NewsletterListController::class, 'show'])->name('lists.show');
Route::delete('lists/{list}', [NewsletterListController::class, 'destroy'])->name('lists.destroy');
Route::delete('lists/{list}/contact/{contact}', [NewsletterListController::class, 'removeContactFromList'])->name('lists.removeContact');
Route::post('lists/{list}/update', [NewsletterListController::class, 'updateContacts'])->name('lists.updateContacts');
Route::get('create-list', [NewsletterListController::class, 'CreateList'])->name('lists.createForm');
Route::post('create-list', [NewsletterListController::class, 'CreateListPost'])->name('lists.createStore');

Route::post('pdf/send/{id}', [PdfController::class, 'sendInvoiceCortesia'])->name('pdf.send');
Route::get('pdf/{model}/{id}', [PdfController::class, 'generate'])->name('pdf.create');

Route::get('products/orders', [ProductController::class, 'orders'])->name('products.orders');
Route::post('products/{product}/orders', [ProductController::class, 'ordersUpdate'])->name('products.ordersUpdate');
Route::get('products/{product}/media', [ProductController::class, 'media'])->name('products.media');
Route::resource('products', ProductController::class);
Route::get('api/products', [ProductController::class, 'apiIndex'])->name('api.products.index');
Route::get('api/products/{product}', [ProductController::class, 'apiShow'])->name('api.products.show');
Route::get('api/ta/products', [ProductController::class, 'taindex'])->name('api.ta.products');

Route::resource('roles', RoleController::class);
Route::resource('settings', SettingController::class)->only(['index', 'edit', 'update']);

Route::get('stats/aziende', [StatController::class, 'companies'])->name('stats.companies');
Route::get('stats/categorie', [StatController::class, 'categories'])->name('stats.categories');
Route::get('stats/categorie/{id}', [StatController::class, 'category'])->name('stats.category');
Route::get('stats/balance', [StatController::class, 'balance'])->name('stats.balance');

Route::get('stores', [StoreController::class, 'index'])->name('stores.index');
Route::get('stores/create', [StoreController::class, 'create'])->name('stores.create');
Route::post('stores', [StoreController::class, 'update'])->name('stores.update');
Route::get('stores/fornitori', [StoreController::class, 'indexFornitori'])->name('stores.fornitori');
Route::post('stores/fornitori', [StoreController::class, 'store'])->name('stores.store');
Route::get('api/ta/stores', [StoreController::class, 'taindex'])->name('api.ta.stores');

Route::get('users', [UserController::class, 'index'])->name('users.index');
Route::post('users', [UserController::class, 'store'])->name('users.store');
Route::get('users/create', [UserController::class, 'create'])->name('users.create');
Route::get('users/{id}/permissions', [UserController::class, 'permissions'])->name('user.permissions');
Route::get('users/{user}', [UserController::class, 'show'])->name('users.show');
Route::patch('users/{user}', [UserController::class, 'update'])->name('users.update');
Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
Route::get('users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::post('api/direct-permissions/{user_id}', [UserController::class, 'permissionUpdate'])->name('api.permissions.update');

Route::get('templates/iframe', [TemplateController::class, 'iframe'])->name('templates.iframe');
Route::get('templates/html/{template}', [TemplateController::class, 'html'])->name('templates.html');
Route::post('templates/{template}', [TemplateController::class, 'update'])->name('templates.update');
Route::resource('templates', TemplateController::class)->except(['create', 'edit', 'update']);

Route::get('works/{work}/media', [WorkController::class, 'media'])->name('works.media');
Route::resource('works', WorkController::class);

Route::post('api/countries', [GeneralController::class, 'prefix'])->name('api.countries.prefix');
Route::post('api/city', [GeneralController::class, 'zip'])->name('api.city.zip');
Route::post('api/clear-cache', [GeneralController::class, 'clearCache'])->name('api.cache.clear');
Route::post('update-field', [GeneralController::class, 'updateField'])->name('global.updateField');
Route::post('switch-locale', [GeneralController::class, 'switchLocale'])->name('global.switchLocale');

Route::group(['prefix' => 'api/media'], function () {
    Route::post('upload', [MediaController::class, 'add'])->name('media.add');
    Route::post('update', [MediaController::class, 'update'])->name('media.update');
    Route::post('order', [MediaController::class, 'sort'])->name('media.sort');
    Route::post('type', [MediaController::class, 'type'])->name('media.type');
    Route::delete('delete',[MediaController::class, 'delete'])->name('media.delete');
});


//ERP

Route::get('logs', [LogController::class, 'index'])->name('erp.logs');
Route::post('logs/truncate', [LogController::class, 'truncate'])->name('erp.logs.clear');

Route::get('erp/checklists/{checkable_id}/{checkable_type}', [CheckController::class, 'manage'])->name('erp.checks.manage');
Route::post('erp/checklists/{checkable_id}/{checkable_type}', [CheckController::class, 'managePost'])->name('erp.checks.managePost');
Route::post('erp/checks/remove', [CheckController::class, 'destroy'])->name('erp.checks.remove');
Route::post('erp/checks/toogle', [CheckController::class, 'toggle'])->name('erp.checks.toggle');

Route::get('erp/ddt', [DdtController::class, 'index'])->name('erp.ddt.index');
Route::get('erp/ddt/{invoice_id}', [DdtController::class, 'show'])->name('erp.ddt.show');
Route::get('erp/ddt/{invoice_id}/pdf', [DdtController::class, 'pdf'])->name('erp.ddt.pdf');
Route::get('erp/ddt/{invoice_id}/edit', [DdtController::class, 'edit'])->name('erp.ddt.edit');
Route::post('erp/ddt/{invoice_id}/add-product', [DdtController::class, 'addProduct'])->name('erp.ddt.product.add');
Route::patch('erp/ddt/{invoice_id}', [DdtController::class, 'update'])->name('erp.ddt.update');
Route::delete('erp/ddt/{invoice_id}', [DdtController::class, 'destroy'])->name('erp.ddt.delete');


Route::get('erp/orders', [OrderErpController::class, 'index'])->name('erp.orders.index');
Route::get('erp/orders/sales', [OrderErpController::class, 'indexSales'])->name('erp.orders.sales');
Route::get('erp/orders/purchases', [OrderErpController::class, 'indexPurchases'])->name('erp.orders.purchases');
Route::get('erp/orders/works', [OrderErpController::class, 'indexWorks'])->name('erp.orders.works');
Route::get('erp/orders/shippings', [OrderErpController::class, 'indexShippings'])->name('erp.orders.shippings');

Route::delete('erp/orders/{order}', [OrderErpController::class, 'destroy'])->name('erp.orders.delete');
Route::get('erp/orders/create', [OrderErpController::class, 'create'])->name('erp.orders.create');

Route::get('erp/orders/purchases/{order_id}', [PurchaseController::class, 'show'])->name('erp.orders.show.purchases');
Route::get('erp/orders/purchases/{order_id}/excel', [PurchaseController::class, 'excel'])->name('erp.orders.excel.purchases');
Route::get('erp/orders/purchases/{order_id}/pdf', [PurchaseController::class, 'pdf'])->name('erp.orders.pdf.purchases');
Route::get('erp/orders/purchases/{order_id}/edit', [PurchaseController::class, 'edit'])->name('erp.orders.edit.purchases');
Route::post('erp/orders/purchases/{purchase}', [PurchaseController::class, 'update'])->name('erp.orders.update.purchases');
Route::get('erp/orders/create/purchases', [PurchaseController::class, 'create'])->name('erp.orders.create.purchases');
Route::post('erp/orders/create/purchases', [PurchaseController::class, 'store'])->name('erp.orders.store.purchases');

Route::get('erp/orders/create/assemblies', [AssemblyController::class, 'create'])->name('erp.orders.create.assemblies');
Route::post('erp/orders/create/assemblies', [AssemblyController::class, 'store'])->name('erp.orders.store.assemblies');
Route::get('erp/orders/assemblies/{order_id}', [AssemblyController::class, 'show'])->name('erp.orders.show.assemblies');
Route::get('erp/orders/assemblies/{order_id}/edit', [AssemblyController::class, 'edit'])->name('erp.orders.edit.assemblies');
Route::post('erp/orders/assemblies/{assembly}', [AssemblyController::class, 'update'])->name('erp.orders.update.assemblies');
Route::get('erp/orders/assemblies/{order_id}/checklist', [AssemblyController::class, 'checklist'])->name('erp.orders.checklist.assemblies');
Route::get('erp/orders/assemblies/{order_id}/dispatch', [AssemblyController::class, 'dispatch'])->name('erp.orders.dispatch.assemblies');

Route::get('erp/orders/assemblies/{order_id}/sn', [AssemblyController::class, 'createSn'])->name('erp.orders.create.assemblies.sn');
Route::post('erp/orders/assemblies/{order_id}/sn', [AssemblyController::class, 'StoreSn'])->name('erp.orders.store.assemblies.sn');



Route::get('erp/orders/create/productions', [ProductionController::class, 'create'])->name('erp.orders.create.productions');
Route::post('erp/orders/create/productions', [ProductionController::class, 'store'])->name('erp.orders.store.productions');
Route::get('erp/orders/preview/productions', [ProductionController::class, 'preview'])->name('erp.orders.preview.productions');

Route::post('erp/orders/create-purchase/productions', [ProductionController::class, 'createPurchase'])->name('erp.orders.create-purchase.productions');
Route::post('erp/orders/create-production/productions', [ProductionController::class, 'createProduction'])->name('erp.orders.create-production.productions');
Route::post('erp/orders/create-purchase-production/productions', [ProductionController::class, 'createPurchaseAndProduction'])->name('erp.orders.create-purchase-production.productions');

Route::get('erp/orders/productions/{order_id}', [ProductionController::class, 'show'])->name('erp.orders.show.productions');
Route::get('erp/orders/productions/{order_id}/{output_id}/edit', [ProductionController::class, 'edit'])->name('erp.orders.edit.productions');
Route::get('erp/orders/productions/{order_id}/{output_id}/complete', [ProductionController::class, 'complete'])->name('erp.orders.complete.productions');
Route::post('erp/orders/productions/{production}', [ProductionController::class, 'update'])->name('erp.orders.update.productions');

Route::get('erp/orders/productions/{order_id}/{output_id}/pdf', [ProductionController::class, 'pdf'])->name('erp.orders.pdf.productions');
Route::get('erp/orders/productions/{order_id}/{output_id}/ddt', [ProductionController::class, 'ddt'])->name('erp.orders.ddt.productions');
Route::get('erp/orders/productions/{order_id}/excel', [ProductionController::class, 'excel'])->name('erp.orders.excel.productions');

Route::get('erp/orders/create/shippings', [ShippingController::class, 'create'])->name('erp.orders.create.shippings');
Route::post('erp/orders/create/shippings', [ShippingController::class, 'store'])->name('erp.orders.store.shippings');
Route::get('erp/orders/shippings/{order_id}', [ShippingController::class, 'show'])->name('erp.orders.show.shippings');
Route::get('erp/orders/create-ddt-available/{id_order}', [ShippingController::class, 'ddtAvailable'])->name('erp.orders.shippings.ddt-available');
Route::get('erp/orders/create-ddt/{id_order}', [ShippingController::class, 'ddt'])->name('erp.orders.shippings.ddt');
