$('.quizContainer').infiniteScroll({
    // options
    path: function () {
        return `${window.basePath}/quizzes/random`
    },
    append: '.postItem',
    history: false,
});
