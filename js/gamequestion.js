const defaultQuestions = {
    "Multiple Choice": {
        "EASY": [
            {
                numb: 1,
                question: "Ano ang \"bag\" sa salitang Agta?",
                answer: "B. hambag",
                options: ["A. layon", "B. hambag", "C. atong", "D. Init"]
            },
            { numb: 2, question: "Ano ang \"aso\" sa salitang Agta?", answer: "B. aso", options: ["A. layon", "B. aso", "C. atong", "D. init"] },
            { numb: 3, question: "Ano ang \"gulay\" sa salitang Agta?", answer: "C. atong", options: ["A. layon", "B. aso", "C. atong", "D. init"] },
            { numb: 4, question: "Ano ang \"isa\" sa salitang Agta?", answer: "B. esa", options: ["A. layon", "B. esa", "C. agent", "D. Init"] },
            { numb: 5, question: "Ano ang \"gabi\" sa salitang Agta?", answer: "D. ganet", options: ["A. layon", "B. lakas", "C. agent", "D. ganet"] },
        ],
        "MEDIUM": [
            { numb: 1, question: "Ano ang \"lupa\" sa salitang Agta?", answer: "A. luta", options: ["A. luta", "B. dila", "C. lasem", "D. multo"] },
            { numb: 2, question: "Ano ang \"paa\" sa salitang Agta?", answer: "B. tikéd", options: ["A. singét", "B. tikéd", "C. parena", "D. ölöng"] },
            { numb: 3, question: "Ano ang \"palay\" sa salitang Agta?", answer: "C. pahay", options: ["A. gusok", "B. manko", "C. pahay", "D. puti"] },
            { numb: 4, question: "Ano ang \"dila\" sa salitang Agta?", answer: "D. ", options: ["A. kawil", "B. maige", "C. ahapay", "D. beg"] },
            { numb: 5, question: "Ano ang \"ilong\" sa salitang Agta?", answer: "A. dungos", options: ["A. dungos", "B. tikéd", "C. parena", "D. singét"] }
        ],
        "HARD": [
            { numb: 1, question: "Ano ang \"guro\" sa salitang Agta?", answer: "B. maistu", options: ["A. ulito", "B. maistu", "C. wasek", "D. yogyog"] },
            { numb: 2, question: "Ano ang \"hati hati\" sa salitang Agta?", answer: "B. tukel", options: ["A. gusok", "B. tukel", "C. udang", "D. puti"] },
            { numb: 3, question: "Ano ang \"binata\" sa salitang Agta?", answer: "B. ulito", options: ["A. busög", "B. ulito", "C. wasek", "D. yogyog"] },
            { numb: 4, question: "Ano ang \"hipon\" sa salitang Agta?", answer: "C. udang", options: ["A. gusok", "B. manko", "C. udang", "D. puti"] },
            { numb: 5, question: "Ano ang \"unat\" sa salitang Agta?", answer: "D. uyan", options: ["A. ulito", "B. tidog", "C. wasek", "D. uyan"] }
        ]
    },
    "Fill In The Blank": {
        "EASY": [
            { numb: 1, question: "Ano ang \"aso\" sa salitang Agta?", answer: "aso" },
            { numb: 2, question: "Ano ang \"araw\" sa salitang Agta?", answer: "aldew" },
            { numb: 3, question: "Ano ang \"tiyo\" sa salitang Agta?", answer: "lele" },
            { numb: 4, question: "Ano ang \"makitasa\" sa salitang Agta?", answer: "meta" },
            { numb: 5, question: "Ano ang \"kailan\" sa salitang Agta?", answer: "kesya" }
        ],
        "MEDIUM": [
            { numb: 1, question: "Ano ang \"araw\" sa salitang Agta?", answer: "araw" },
            { numb: 2, question: "Ano ang \"magkano\" sa salitang Agta?", answer: "sanganya" },
            { numb: 3, question: "Ano ang \"alin\" sa salitang Agta?", answer: "nahe" },
            { numb: 4, question: "Ano ang \"malapit\" sa salitang Agta?", answer: "asadek" },
            { numb: 5, question: "Ano ang \"tatay\" sa salitang Agta?", answer: "ameng" }
        ],
        "HARD": [
            { numb: 1, question: "Ano ang \"dibdib\" sa salitang Agta?", answer: "hako" },
            { numb: 2, question: "Ano ang \"pamangkin\" sa salitang Agta?", answer: "aneng" },
            { numb: 3, question: "Ano ang \"marinig\" sa salitang Agta?", answer: "mabate" },
            { numb: 4, question: "Ano ang \"tumayo\" sa salitang Agta?", answer: "tumakneg" },
            { numb: 5, question: "Ano ang \"bunso\" sa salitang Agta?", answer: "depos" }
        ]
    }
};

// This will store custom questions from the database






























let customQuestions = {
    "Multiple Choice": {
        "EASY": [],
        "MEDIUM": [],
        "HARD": []
    },
    "Fill In The Blank": {
        "EASY": [],
        "MEDIUM": [],
        "HARD": []
    }
};

// Combine default and custom questions
const allQuestions = {
    "Multiple Choice": {
        "EASY": [...defaultQuestions["Multiple Choice"]["EASY"], ...customQuestions["Multiple Choice"]["EASY"]],
        "MEDIUM": [...defaultQuestions["Multiple Choice"]["MEDIUM"], ...customQuestions["Multiple Choice"]["MEDIUM"]],
        "HARD": [...defaultQuestions["Multiple Choice"]["HARD"], ...customQuestions["Multiple Choice"]["HARD"]]
    },
    "Fill In The Blank": {
        "EASY": [...defaultQuestions["Fill In The Blank"]["EASY"], ...customQuestions["Fill In The Blank"]["EASY"]],
        "MEDIUM": [...defaultQuestions["Fill In The Blank"]["MEDIUM"], ...customQuestions["Fill In The Blank"]["MEDIUM"]],
        "HARD": [...defaultQuestions["Fill In The Blank"]["HARD"], ...customQuestions["Fill In The Blank"]["HARD"]]
    }
};
