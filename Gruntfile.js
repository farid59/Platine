module.exports = function (grunt) {
    require('load-grunt-tasks')(grunt);

    // utile pour la suite
    var outputRoot = "web/";

    grunt.initConfig({
        // Compiler les fichiers LESS et concaténer tous les CSS en un seul
        // fichier css/styles.css
        less: {
            dist: {
                src:[
                    // On ajoute bootstrap et font-awesome
                    './libs/bootstrap/dist/css/bootstrap.css',
                    './libs/font-awesome/css/font-awesome.css',

                    // On ajoute les fichiers less des dossiers public des bundles
                    // C'est cette syntaxe qui permet de prendre en compte TOUS les fichiers less de TOUS les bundles
                    './src/*/*Bundle/public/LESS/*'
                ],
                dest: outputRoot+"css/styles.css"
            }
        },

        // Concaténer tous les fichiers JS en un seul fichier
        // js/scripts.js
        concat: {
            dist: {
                src: [
                    // On ajoute bootstrap et jquery
                    './libs/jquery/dist/jquery.js',
                    './libs/bootstrap/dist/js/bootstrap.js',

                    // On ajoute les fichiers js des dossiers public des bundles
                    // C'est cette syntaxe qui permet de prendre en compte TOUS les fichiers css de TOUS les bundles
                    './src/*/*Bundle/public/JS/*'
                ],
                dest: outputRoot+"js/scripts.js"
            }
        },

        // minifier js/scripts.js en js/scripts.min.js
        uglify: {
            dist: {
                src: [outputRoot+'js/scripts.js'],
                dest: outputRoot+'js/scripts.min.js'
            }
        },

        // minifier css/styles.css en css/styles.min.css
        cssmin: {
            dist: {
                src: [outputRoot+'css/styles.css'],
                dest: outputRoot+'css/styles.min.css'
            }
        },

        // Copier les fonts des librairies au bon endroit pour
        // les css
        copy: {
            fonts: {
                files: [
                    // Les fonts de bootstrap
                    {expand: true, cwd: './libs/bootstrap/fonts/', src:['**'], dest: outputRoot+"fonts/"},
                    // Les conts de font-awesome
                    {expand: true, cwd: './libs/font-awesome/fonts', src:['**'], dest: outputRoot+"fonts/"}
                ]
            }
        },

        // configuration de la tache watch (a chaque modification de fichier,
        // on lance la tache default)
        watch: {
            files:['**'],
            tasks:['default']
        }
    });

    // On n'oublie pas d'ajouter les modules configurés dans le tableau
    // ca sert à dire à grunt "pour la tache default, utilise les modules
    // que je t'indiques"
    grunt.registerTask('default',['less','concat','uglify','cssmin','copy']);

    // On n'oublie pas d'enregistrer la tache :
    grunt.registerTask('watch-src', ['default','watch']);
}