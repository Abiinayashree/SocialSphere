$(document).ready(function () {

    // ==============================
    // LIKE
    // ==============================

    $(document).on("click", ".like-btn", function () {

        var postId = parseInt(
            $(this).attr("data-post-id"),
            10
        );

        var scope = angular.element(document.body).scope();

        if (scope) {

            scope.$apply(function () {
                scope.handleLike(postId);
            });

        }

    });


    // ==============================
    // OPEN / CLOSE COMMENT BOX
    // ==============================

    $(document).on("click", ".comment-btn", function () {

        var postCard = $(this).closest(".post-card");

        postCard.find(".comment-box").slideToggle(200);

    });


    // ==============================
    // POST COMMENT
    // ==============================

    $(document).on("click", ".comment-submit", function () {

        var button = $(this);

        var postCard = button.closest(".post-card");

        var postId = postCard.attr("data-post-id");

        var input = postCard.find(".comment-input");

        var commentText = input.val();


        if (!commentText || commentText.trim() === "") {
            return;
        }


        var scope = angular.element(document.body).scope();


        if (scope) {

            scope.$apply(function () {

                scope.addComment(
                    postId,
                    commentText
                );

            });

            // Clear input after posting
            input.val("");

        }

    });


    // ==============================
    // ENTER KEY
    // ==============================

    $(document).on(
        "keypress",
        ".comment-input",
        function (event) {

            if (event.which === 13) {

                event.preventDefault();

                $(this)
                    .closest(".comment-box")
                    .find(".comment-submit")
                    .click();

            }

        }
    );

});