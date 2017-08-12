<?php

class helper_plugin_translate extends DokuWiki_Plugin {
    /**
     * @var string[][]
     */
    private $translationsList =
        [
            [
                'cs' => 'ulohy:rocnik@year@:serie@series@',
                'en' => 'task:year@year@:series@series@',
            ],
            [
                'cs' => 'akce:start',
                'en' => 'events:start',
            ],

        ];

    public function getAvailableTranslations($id) {
        $list = $this->getTranslationsList();
        foreach ($list as $translation) {
            foreach ($translation as $lang => $pattern) {
                list($patternID, $variables) = $this->preparePattern($pattern);
                if (preg_match('/^:?' . $patternID . '/', $id, $matches)) {
                    return ['ids' => $this->createPageIds($variables, $translation, $matches), 'lang' => $lang];
                }
            }
        }
    }

    private function getTranslationsList() {

        return $this->translationsList;
        /*  $content = io_readFile(metaFN(':translate:list', 'list '));
          if (!$content) {
              return [];
          }
          return unserialize($content);*/
    }

    private function preparePattern($pattern) {
        preg_match_all('/@[a-z]+@/', $pattern, $matches);
        $newPattern = preg_replace('/@[a-z]+@/', '([0-9]+)', $pattern);
        $variables = $matches[0];
        return [$newPattern, $variables];
    }

    private function createPageIds($variables, $translation, $matches) {
        $ids = [];
        foreach ($translation as $lang => $pagePattern) {
            $id = $pagePattern;
            foreach ($variables as $key => $variableName) {
                $id = str_replace($variableName, $matches[$key + 1], $id);
            }
            if (page_exists($id)) {
                $ids[] = ['lang' => $lang, 'id' => $id];
            }
        }
        var_dump($ids);
        return $ids;

    }

    public static function getLangName($code) {

        $langNames = [
            'aa' => 'Afar',
            'ab' => 'Аҧсуа',
            'af' => 'Afrikaans',
            'ak' => 'Akana',
            'als' => 'Alemannisch',
            'am' => 'አማርኛ',
            'an' => 'Aragonés',
            'ang' => 'Englisc',
            'ar' => 'العربية',
            'arc' => 'ܣܘܪܬ',
            'as' => 'অসমীয়া',
            'ast' => 'Asturianu',
            'av' => 'Авар',
            'ay' => 'Aymar',
            'az' => 'Azərbaycanca / آذربايجان',
            'ba' => 'Башҡорт',
            'bar' => 'Boarisch',
            'bat-smg' => 'Žemaitėška',
            'bcl' => 'Bikol Central',
            'be' => 'Беларуская',
            'be-x-old' => 'Беларуская (тарашкевіца)',
            'bg' => 'Български',
            'bh' => 'भोजपुरी',
            'bi' => 'Bislama',
            'bm' => 'Bamanankan',
            'bn' => 'বাংলা',
            'bo' => 'བོད་ཡིག / Bod skad',
            'bpy' => 'ইমার ঠার/বিষ্ণুপ্রিয়া মণিপুরী',
            'br' => 'Brezhoneg',
            'bs' => 'Bosanski',
            'bug' => 'ᨅᨔ ᨕᨘᨁᨗ / Basa Ugi',
            'bxr' => 'Буряад хэлэн',
            'ca' => 'Català',
            'ce' => 'Нохчийн',
            'ceb' => 'Sinugboanong Binisaya',
            'ch' => 'Chamoru',
            'cho' => 'Choctaw',
            'chr' => 'ᏣᎳᎩ',
            'chy' => 'Tsetsêhestâhese',
            'co' => 'Corsu',
            'cr' => 'Nehiyaw',
            'cs' => 'Česky',
            'csb' => 'Kaszëbsczi',
            'cu' => 'словѣньскъ / slověnĭskŭ',
            'cv' => 'Чăваш',
            'cy' => 'Cymraeg',
            'da' => 'Dansk',
            'de' => 'Deutsch',
            'diq' => 'Zazaki',
            'dsb' => 'Dolnoserbski',
            'dv' => 'ދިވެހިބަސް',
            'dz' => 'ཇོང་ཁ',
            'ee' => 'Ɛʋɛ',
            'el' => 'Ελληνικά',
            'en' => 'English',
            'eo' => 'Esperanto',
            'es' => 'Español',
            'et' => 'Eesti',
            'eu' => 'Euskara',
            'ext' => 'Estremeñu',
            'fa' => 'فارسی',
            'ff' => 'Fulfulde',
            'fi' => 'Suomi',
            'fiu-vro' => 'Võro',
            'fj' => 'Na Vosa Vakaviti',
            'fo' => 'Føroyskt',
            'fr' => 'Français',
            'frp' => 'Arpitan / francoprovençal',
            'fur' => 'Furlan',
            'fy' => 'Frysk',
            'ga' => 'Gaeilge',
            'gd' => 'Gàidhlig',
            'gil' => 'Taetae ni kiribati',
            'gl' => 'Galego',
            'gn' => 'Avañe\'ẽ',
            'got' => 'gutisk',
            'gu' => 'ગુજરાતી',
            'gv' => 'Gaelg',
            'ha' => 'هَوُسَ',
            'haw' => 'Hawai`i',
            'he' => 'עברית',
            'hi' => 'हिन्दी',
            'ho' => 'Hiri Motu',
            'hr' => 'Hrvatski',
            'ht' => 'Krèyol ayisyen',
            'hu' => 'Magyar',
            'hy' => 'Հայերեն',
            'hz' => 'Otsiherero',
            'ia' => 'Interlingua',
            'id' => 'Bahasa Indonesia',
            'ie' => 'Interlingue',
            'ig' => 'Igbo',
            'ii' => 'ꆇꉙ / 四川彝语',
            'ik' => 'Iñupiak',
            'ilo' => 'Ilokano',
            'io' => 'Ido',
            'is' => 'Íslenska',
            'it' => 'Italiano',
            'iu' => 'ᐃᓄᒃᑎᑐᑦ',
            'ja' => '日本語',
            'jbo' => 'Lojban',
            'jv' => 'Basa Jawa',
            'ka' => 'ქართული',
            'kg' => 'KiKongo',
            'ki' => 'Gĩkũyũ',
            'kj' => 'Kuanyama',
            'kk' => 'Қазақша',
            'kl' => 'Kalaallisut',
            'km' => 'ភាសាខ្មែរ',
            'kn' => 'ಕನ್ನಡ',
            'ko' => '한국어',
            'kr' => 'Kanuri',
            'ks' => 'कश्मीरी / كشميري',
            'ksh' => 'Ripoarisch',
            'ku' => 'Kurdî / كوردی',
            'kv' => 'Коми',
            'kw' => 'Kernewek / Karnuack',
            'ky' => 'Kırgızca / Кыргызча',
            'la' => 'Latina',
            'lad' => 'Dzhudezmo / Djudeo-Espanyol',
            'lan' => 'Leb Lango / Luo',
            'lb' => 'Lëtzebuergesch',
            'lg' => 'Luganda',
            'li' => 'Limburgs',
            'lij' => 'Líguru',
            'lmo' => 'Lumbaart',
            'ln' => 'Lingála',
            'lo' => 'ລາວ / Pha xa lao',
            'lt' => 'Lietuvių',
            'lv' => 'Latviešu',
            'map-bms' => 'Basa Banyumasan',
            'mg' => 'Malagasy',
            'mh' => 'Kajin Majel / Ebon',
            'mi' => 'Māori',
            'mk' => 'Македонски',
            'ml' => 'മലയാളം',
            'mn' => 'Монгол',
            'mo' => 'Moldovenească',
            'mr' => 'मराठी',
            'ms' => 'Bahasa Melayu',
            'mt' => 'bil-Malti',
            'mus' => 'Mvskoke',
            'my' => 'Myanmasa',
            'na' => 'Dorerin Naoero',
            'nah' => 'Nahuatl',
            'nap' => 'Nnapulitano',
            'nd' => 'Sindebele',
            'nds' => 'Plattdüütsch',
            'nds-nl' => 'Nedersaksisch',
            'ne' => 'नेपाली',
            'new' => 'नेपालभाषा / Newah Bhaye',
            'ng' => 'Oshiwambo',
            'nl' => 'Nederlands',
            'nn' => 'Norsk (nynorsk)',
            'no' => 'Norsk (bokmål / riksmål)',
            'nr' => 'isiNdebele',
            'nso' => 'Sesotho sa Leboa / Sepedi',
            'nrm' => 'Nouormand / Normaund',
            'nv' => 'Diné bizaad',
            'ny' => 'Chi-Chewa',
            'oc' => 'Occitan',
            'oj' => 'ᐊᓂᔑᓈᐯᒧᐎᓐ / Anishinaabemowin',
            'om' => 'Oromoo',
            'or' => 'ଓଡ଼ିଆ',
            'os' => 'Иронау',
            'pa' => 'ਪੰਜਾਬੀ / पंजाबी / پنجابي',
            'pag' => 'Pangasinan',
            'pam' => 'Kapampangan',
            'pap' => 'Papiamentu',
            'pdc' => 'Deitsch',
            'pi' => 'Pāli / पाऴि',
            'pih' => 'Norfuk',
            'pl' => 'Polski',
            'pms' => 'Piemontèis',
            'ps' => 'پښتو',
            'pt' => 'Português',
            'qu' => 'Runa Simi',
            'rm' => 'Rumantsch',
            'rmy' => 'Romani / रोमानी',
            'rn' => 'Kirundi',
            'ro' => 'Română',
            'roa-rup' => 'Armâneashti',
            'ru' => 'Русский',
            'rw' => 'Kinyarwandi',
            'sa' => 'संस्कृतम्',
            'sc' => 'Sardu',
            'scn' => 'Sicilianu',
            'sco' => 'Scots',
            'sd' => 'सिनधि',
            'se' => 'Sámegiella',
            'sg' => 'Sängö',
            'sh' => 'Srpskohrvatski / Српскохрватски',
            'si' => 'සිංහල',
            'simple' => 'Simple English',
            'sk' => 'Slovenčina',
            'sl' => 'Slovenščina',
            'sm' => 'Gagana Samoa',
            'sn' => 'chiShona',
            'so' => 'Soomaaliga',
            'sq' => 'Shqip',
            'sr' => 'Српски',
            'ss' => 'SiSwati',
            'st' => 'Sesotho',
            'su' => 'Basa Sunda',
            'sv' => 'Svenska',
            'sw' => 'Kiswahili',
            'ta' => 'தமிழ்',
            'te' => 'తెలుగు',
            'tet' => 'Tetun',
            'tg' => 'Тоҷикӣ',
            'th' => 'ไทย / Phasa Thai',
            'ti' => 'ትግርኛ',
            'tk' => 'Туркмен / تركمن',
            'tl' => 'Tagalog',
            'tlh' => 'tlhIngan-Hol',
            'tn' => 'Setswana',
            'to' => 'Lea Faka-Tonga',
            'tpi' => 'Tok Pisin',
            'tr' => 'Türkçe',
            'ts' => 'Xitsonga',
            'tt' => 'Tatarça',
            'tum' => 'chiTumbuka',
            'tw' => 'Twi',
            'ty' => 'Reo Mā`ohi',
            'udm' => 'Удмурт кыл',
            'ug' => 'Uyƣurqə / ئۇيغۇرچە',
            'uk' => 'Українська',
            'ur' => 'اردو',
            'uz' => 'Ўзбек',
            've' => 'Tshivenḓa',
            'vi' => 'Tiếng Việt',
            'vec' => 'Vèneto',
            'vls' => 'West-Vlaoms',
            'vo' => 'Volapük',
            'wa' => 'Walon',
            'war' => 'Winaray / Binisaya Lineyte-Samarnon',
            'wo' => 'Wollof',
            'xal' => 'Хальмг',
            'xh' => 'isiXhosa',
            'yi' => 'ייִדיש',
            'yo' => 'Yorùbá',
            'za' => 'Cuengh / Tôô / 壮语',
            'zh' => '中文',
            'zh-min-nan' => 'Bân-lâm-gú',
            'zh-yue' => '粵語 / 粤语',
            'zu' => 'isiZulu',
        ];
        return $langNames[$code];
    }
}
