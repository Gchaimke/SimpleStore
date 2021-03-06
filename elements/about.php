<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">About Simple Price List</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Autor:<a href="mailto:gchaimke@gmail.com"> Chaim Gorbov</a></p>
                <p>Version: <?=VERSION?></p>
                <p>Date: 05.05.2021</p>
                <p>In this project: HTML5, CSS, JS, Jquery, Bootstrap 5, PHP 7.4</p>

                <p>
                    <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#ru" aria-expanded="false" aria-controls="ru">Русский</button>
                    <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#eng" aria-expanded="false" aria-controls="eng ru">English</button>
                    <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#he" aria-expanded="false" aria-controls="he">עברית</button>
                </p>
                <div class="col">
                    <div class="collapse" id="he">
                        <div class="card card-body rtl">
                            <div>
                                הרבה אנשים משתמשים במדיה חברתית כדי למכור את המוצרים שלהם.
                                הם משתמשים בדרכים שונות כדי להציג את רשימת המוצרים שלהם, כל פעם נאבקים עם העיצוב והעדכון הזה.
                                ולקוחותיהם צריכים לכתוב מחדש או להעתיק את שמות הסחורות בהתכתבות האישית שלהם לצורך ההזמנה.
                                <p> הכנתי יישום פשוט עם הפונקציות הבאות: </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="collapse" id="eng">
                        <div class="card card-body">
                            <div style="direction: ltr;">
                                A lot of people use social media to sell their products.
                                They use different ways to show their list of products, each time struggling with this design and update.
                                And their customers have to rewrite or copy the names of the goods in their personal correspondence for the order.
                                <p>I made a simple application with the following functions:</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="collapse show" id="ru">
                        <div class="card card-body">
                            <div style="direction: ltr;">
                                Много людей используют социальные сети для продаж своих товаров.
                                Они используют разные способы показать свой список товаров,
                                каждый раз мучаясь с его оформлением и обновлением.
                                А их клиенты должны переписовать или копировать названия товаров в личную переписку для заказа.
                                <p>Я сделал простое приложение со следующими функциями:</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>