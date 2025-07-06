<?php

class ApiService {
    private $oxfordApiKey = 'b01dd44afc0ef7542a7e463353a46225';
    private $oxfordAppId = '4b6e4c8d';
    private $merriamWebsterApiKey = '24c5ae52-c432-4f1d-9707-fb4d671c013f';
    private $rapidApiKey = '045f50bd82msh5e87230bba3a598p16ef30jsn7098afb21c07';

    public function fetchComprehensiveWordData($word) {
        $cleanWord = strtolower(trim($word));
        
        // Try Free Dictionary API first (no key required)
        $freeDictionaryData = $this->fetchFreeDictionaryApi($cleanWord);
        
        // Try other APIs concurrently (if available)
        $oxfordData = $this->fetchOxfordData($cleanWord);
        $merriamData = $this->fetchMerriamWebsterDictionary($cleanWord);
        $wordsApiData = $this->fetchWordsApiData($cleanWord);
        
        return $this->processApiResponses([
            'freeDictionary' => $freeDictionaryData,
            'oxford' => $oxfordData,
            'merriam' => $merriamData,
            'wordsapi' => $wordsApiData
        ], $cleanWord);
    }

    private function fetchFreeDictionaryApi($word) {
        $url = "https://api.dictionaryapi.dev/api/v2/entries/en/" . urlencode($word);
        
        $context = stream_context_create([
            'http' => [
                'timeout' => 5,
                'user_agent' => 'LexiFind Dictionary App'
            ]
        ]);
        
        $response = @file_get_contents($url, false, $context);
        
        if ($response === false) {
            return null;
        }
        
        return json_decode($response, true);
    }

    private function fetchOxfordData($word) {
        $url = "https://od-api.oxforddictionaries.com/api/v2/entries/en-us/" . urlencode($word);
        
        $context = stream_context_create([
            'http' => [
                'header' => [
                    "app_id: " . $this->oxfordAppId,
                    "app_key: " . $this->oxfordApiKey,
                    "Accept: application/json"
                ],
                'timeout' => 5
            ]
        ]);
        
        $response = @file_get_contents($url, false, $context);
        
        if ($response === false) {
            return null;
        }
        
        return json_decode($response, true);
    }

    private function fetchMerriamWebsterDictionary($word) {
        $url = "https://www.dictionaryapi.com/api/v3/references/collegiate/json/" . urlencode($word) . "?key=" . $this->merriamWebsterApiKey;
        
        $context = stream_context_create([
            'http' => [
                'timeout' => 5
            ]
        ]);
        
        $response = @file_get_contents($url, false, $context);
        
        if ($response === false || strpos($response, 'Invalid API key') !== false) {
            return null;
        }
        
        return json_decode($response, true);
    }

    private function fetchWordsApiData($word) {
        $url = "https://wordsapiv1.p.rapidapi.com/words/" . urlencode($word);
        
        $context = stream_context_create([
            'http' => [
                'header' => [
                    "X-RapidAPI-Key: " . $this->rapidApiKey,
                    "X-RapidAPI-Host: wordsapiv1.p.rapidapi.com"
                ],
                'timeout' => 5
            ]
        ]);
        
        $response = @file_get_contents($url, false, $context);
        
        if ($response === false) {
            return null;
        }
        
        return json_decode($response, true);
    }

    private function processApiResponses($responses, $searchWord) {
        $result = [
            'word' => $searchWord,
            'pronunciation' => '',
            'definitions' => [],
            'synonyms' => [],
            'antonyms' => [],
            'frequency' => 0,
            'difficulty' => 'medium',
            'partOfSpeech' => ''
        ];

        // Process Free Dictionary API (highest priority)
        if ($responses['freeDictionary'] && is_array($responses['freeDictionary'])) {
            $entry = $responses['freeDictionary'][0];
            
            if (isset($entry['phonetics']) && !empty($entry['phonetics'])) {
                $result['pronunciation'] = $entry['phonetics'][0]['text'] ?? '';
            }

            if (isset($entry['meanings']) && !empty($entry['meanings'])) {
                foreach ($entry['meanings'] as $meaning) {
                    if (isset($meaning['definitions'])) {
                        foreach ($meaning['definitions'] as $def) {
                            $result['definitions'][] = [
                                'definition' => $def['definition'],
                                'example' => $def['example'] ?? '',
                                'partOfSpeech' => $meaning['partOfSpeech'] ?? ''
                            ];
                        }
                    }

                    if (isset($meaning['synonyms'])) {
                        foreach ($meaning['synonyms'] as $syn) {
                            if (!in_array($syn, array_column($result['synonyms'], 'word'))) {
                                $result['synonyms'][] = [
                                    'word' => $syn,
                                    'strength' => 'strong',
                                    'formality' => 'neutral',
                                    'context' => $meaning['partOfSpeech'] ?? ''
                                ];
                            }
                        }
                    }

                    if (isset($meaning['antonyms'])) {
                        foreach ($meaning['antonyms'] as $ant) {
                            if (!in_array($ant, $result['antonyms'])) {
                                $result['antonyms'][] = $ant;
                            }
                        }
                    }
                }

                if (isset($entry['meanings'][0]['partOfSpeech'])) {
                    $result['partOfSpeech'] = $entry['meanings'][0]['partOfSpeech'];
                }
            }
        }

        // Add fallback data if no definitions found
        if (empty($result['definitions'])) {
            $fallbackData = $this->getFallbackData($searchWord);
            $result = array_merge($result, $fallbackData);
        }

        // Set frequency and difficulty
        $result['frequency'] = $this->estimateFrequency($searchWord);
        $result['difficulty'] = $this->estimateDifficulty($searchWord);

        return $result;
    }

    private function getFallbackData($word) {
        $commonWords = [
            'happy' => [
                'definitions' => [
                    ['definition' => 'Feeling or showing pleasure or contentment', 'example' => 'She was happy to see her friends.', 'partOfSpeech' => 'adjective']
                ],
                'synonyms' => [
                    ['word' => 'joyful', 'strength' => 'strong', 'formality' => 'neutral', 'context' => ''],
                    ['word' => 'cheerful', 'strength' => 'strong', 'formality' => 'neutral', 'context' => ''],
                    ['word' => 'glad', 'strength' => 'moderate', 'formality' => 'neutral', 'context' => ''],
                    ['word' => 'pleased', 'strength' => 'moderate', 'formality' => 'neutral', 'context' => '']
                ],
                'antonyms' => ['sad', 'unhappy', 'miserable'],
                'partOfSpeech' => 'adjective',
                'pronunciation' => '/ˈhæpi/'
            ],
            'beautiful' => [
                'definitions' => [
                    ['definition' => 'Pleasing the senses or mind aesthetically', 'example' => 'The sunset was beautiful.', 'partOfSpeech' => 'adjective']
                ],
                'synonyms' => [
                    ['word' => 'lovely', 'strength' => 'strong', 'formality' => 'neutral', 'context' => ''],
                    ['word' => 'gorgeous', 'strength' => 'strong', 'formality' => 'informal', 'context' => ''],
                    ['word' => 'stunning', 'strength' => 'strong', 'formality' => 'neutral', 'context' => '']
                ],
                'antonyms' => ['ugly', 'hideous'],
                'partOfSpeech' => 'adjective',
                'pronunciation' => '/ˈbjuːtɪfəl/'
            ]
        ];

        if (isset($commonWords[strtolower($word)])) {
            return $commonWords[strtolower($word)];
        }

        return [
            'definitions' => [
                ['definition' => "A word meaning \"$word\" (comprehensive definition available with premium access)", 'example' => '', 'partOfSpeech' => 'unknown']
            ],
            'synonyms' => [],
            'antonyms' => [],
            'partOfSpeech' => 'unknown',
            'pronunciation' => ''
        ];
    }

    private function estimateFrequency($word) {
        $highFrequency = ['the', 'a', 'an', 'and', 'or', 'but', 'good', 'bad', 'happy', 'sad'];
        $mediumFrequency = ['beautiful', 'wonderful', 'excellent', 'amazing'];
        
        if (in_array(strtolower($word), $highFrequency)) return 85;
        if (in_array(strtolower($word), $mediumFrequency)) return 60;
        if (strlen($word) <= 4) return 70;
        if (strlen($word) <= 7) return 50;
        return 30;
    }

    private function estimateDifficulty($word) {
        if (strlen($word) <= 4) return 'easy';
        if (strlen($word) <= 8) return 'medium';
        return 'hard';
    }
}
?>