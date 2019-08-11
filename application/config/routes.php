<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
//$route['default_controller'] = 'subscribe/index';
$route['privacy-policy.html'] = 'subscribe/privacy';
$route['default_controller'] = 'home';
//$route['default_controller'] = 'lite_library/index';
//$route['cart'] = 'lite_library/index';
$route['admin/blog/post-b'] = "admin/blog/manage_blog_posts";
$route['admin/blog/add-post'] = "admin/Blog/editPost";
$route['admin/blog/edit-post/(:any)'] = "admin/blog/editPost/$1";
$route['admin/blog/delete-post'] = "admin/blog/delete_post";
$route['admin/blog/view-comments/(:any)'] = "admin/blog/view_post_comments/$1";
$route['admin/blog/add-comment/(:any)'] = "admin/blog/add_post_comment/$1";
$route['admin/blog/edit-post-comment/(:any)/(:any)'] = "admin/blog/edit_post_comment/$1/$2";
$route['admin/blog/delete-post-comment'] = "admin/blog/delete_post_comment";
$route['admin/blog/lang-posts/(:any)'] = "admin/blog/lang_post/$1";
$route['admin/blog/get-language-for-posts'] = "admin/blog/get_language_for_posts";
$route['admin/blog/blog-category'] = "admin/blog/blogCategory";
$route['admin/blog/check-blog-category'] = "admin/blog/checkCategoryName";
$route['admin/blog/check-blog-edit-category'] = "admin/blog/checkEditCategoryName";
$route['admin/blog/add-category'] = "admin/blog/add_category";
$route['admin/blog/delete-category'] = "admin/blog/delete_category";
$route['admin/blog/edit-category/(:any)'] = "admin/blog/edit_category/$1";
$route['admin/blog/author-list'] = "admin/blog/blog_author";
$route['admin/blog/add-author'] = "admin/blog/add_author";
$route['admin/blog/delete-author'] = "admin/blog/delete_author";
$route['admin/blog/edit-author/(:any)'] = "admin/blog/edit_author/$1";
$route['admin/blog/validate-page-url'] = "admin/blog/validatePageUrl";

/*
 * Routes for inventory clover
 */
$route['admin/inventory/list'] = "admin/inventory/cloverInventory";
$route['admin/inventory/list/(:any)'] = "admin/inventory/cloverInventory/$1";
$route['admin/inventory/orders'] = "admin/inventory/cloverOrders";
$route['admin/inventory/orders/(:any)'] = "admin/inventory/cloverOrders/$1";
$route['admin/inventory/order-details/(:any)'] = "admin/inventory/cloverOrderDetails/$1";
$route['admin/inventory/stock'] = "admin/inventory/cloverInventory";

$route['admin/inventory/clover-products'] = "admin/inventory/getAllProducts";
$route['admin/inventory/clover-products/(:any)'] = "admin/inventory/getAllProducts/$1";
$route['admin/inventory/edit-clover-product/(:any)'] = "admin/inventory/cloverProductDetails/$1";
$route['admin/inventory/delete-clover-product/(:any)'] = "admin/inventory/deleteCloverProduct/$1";
/* Newsletter Start-Here */
$route['admin/newsletter/list'] = "admin/newsletter/listNewsletter";
$route['admin/newsletter/add'] = "admin/newsletter/addNewsletter";
$route['admin/newsletter/change-status'] = "admin/newsletter/changeStatus";
$route['admin/newsletter/edit/(:any)'] = "admin/newsletter/editNewsletter/$1";
$route['admin/send-newsletter/(:any)'] = "admin/newsletter/sendNewsletter/$1";
$route['admin/newsletter/upload-cleditor-image'] = "admin/newsletter/uploadClEditorImage";

/* inventory Start-Here */
$route['admin/inventory/store-list'] = "admin/Inventory/storeList";
$route['admin/inventory/add-store'] = "admin/Inventory/addStore";
$route['admin/inventory/edit-store'] = "admin/Inventory/editStore";
$route['admin/inventory/edit-store/(:any)'] = "admin/Inventory/editStore/$1";
$route['admin/inventory/change-status'] = "admin/Inventory/changeStatus";
$route['admin/inventory/store-stock'] = "admin/Inventory/storeStock";

$route['newsletter-subscription'] = "admin/newsletter/addNewsletterSubscriber";
$route['newsletter-unsubscribe/(:any)'] = "admin/newsletter/newsletterUnsubscribed/$1";
$route['newsletter-subscribe/(:any)'] = "admin/newsletter/newsletterSubscribed/$1";
$route['chk-email-duplicate-news'] = "admin/newsletter/chkEmailDuplicate";
$route['admin/newsletter-subscriber/list'] = "admin/Newsletter_Subscriber/listSubscriberNewsletter";
$route['admin/subscriber-newsletter/change-status'] = "admin/Newsletter_Subscriber/changeStatus";
$route['admin/newsletter_subscriber/addNewsletterSubscriber'] = "admin/Newsletter_Subscriber/addNewsletterSubscriber";


$route['clover_test.php'] = "admin/updateStockFromCloverWebhook";

$route['admin/testimonial/list'] = "admin/testimonial/listTestimonial";
$route['admin/testimonial/change-status'] = "admin/testimonial/changeStatus";
$route['admin/testimonial/add/(:any)'] = "admin/testimonial/addTestimonial/$1";
$route['admin/testimonial/add'] = "admin/testimonial/addTestimonial";
$route['admin/testimonial/change-homepage-testimonial-status'] = "admin/testimonial/changeHomePageTestimonialStatus";
$route['admin/testimonial/get-suburbs-for-autocomplete'] = "admin/testimonial/getSuburbsAutocomplete";
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['user-newsletter-unsubscribe'] = 'subscribe/newsletterUnsubscribe';
