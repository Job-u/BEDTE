const defaultQuestions = {
    "Multiple Choice": {
        "EASY": [
            {
                numb: 1,
                question: "Ano ang \"aso\" sa Agta?",
                answer: "B. Aso",
                options: ["A. Layon", "B. Aso", "C. atong", "D. Init"]
            },
            { numb: 2, question: "Ano ang \"aso\" sa Agta?", answer: "B. Aso", options: ["A. layon", "B. aso", "C. atong", "D. init"] },
            { numb: 3, question: "Ano ang \"gulay\" sa Agta?", answer: "C. atong", options: ["A. layon", "B. aso", "C. atong", "D. init"] },
            { numb: 4, question: "Ano ang \"isa\" sa Agta?", answer: "B. esa", options: ["A. layon", "B. esa", "C. agent", "D. Init"] },
            { numb: 5, question: "Ano ang \"gabi\" sa Agta?", answer: "D. ganet", options: ["A. layon", "B. lakas", "C. agent", "D. ganet"] },
        ],
        "MEDIUM": [
            { numb: 1, question: "Ano ang \"lupa\" sa Agta?", answer: "A. luta", options: ["A. luta", "B. dila", "C. lasem", "D. multo"] },
            { numb: 2, question: "Ano ang \"paa\" sa Agta?", answer: "B. tikéd", options: ["A. singét", "B. tikéd", "C. parena", "D. ölöng"] },
            { numb: 3, question: "Ano ang \"palay\" sa Agta?", answer: "C. pahay", options: ["A. gusok", "B. manko", "C. pahay", "D. puti"] },
            { numb: 4, question: "Ano ang \"dila\" sa Agta?", answer: "D. ", options: ["A. kawil", "B. maige", "C. ahapay", "D. beg"] },
            { numb: 5, question: "Ano ang \"ilong\" sa Agta?", answer: "A. dungos", options: ["A. dungos", "B. tikéd", "C. parena", "D. singét"] }
        ],
        "HARD": [
            { numb: 1, question: "Ano ang \"guro\" sa Agta?", answer: "B. maistu", options: ["A. ulito", "B. maistu", "C. wasek", "D. yogyog"] },
            { numb: 2, question: "Ano ang \"hati hati\" sa Agta?", answer: "B. tukel", options: ["A. gusok", "B. tukel", "C. udang", "D. puti"] },
            { numb: 3, question: "Ano ang \"binata\" sa Agta?", answer: "B. ulito", options: ["A. busög", "B. ulito", "C. wasek", "D. yogyog"] },
            { numb: 4, question: "Ano ang \"hipon\" sa Agta?", answer: "C. udang", options: ["A. gusok", "B. manko", "C. udang", "D. puti"] },
            { numb: 5, question: "Ano ang \"unat\" sa Agta?", answer: "D. uyan", options: ["A. ulito", "B. tidog", "C. wasek", "D. uyan"] }
        ]
    },
    "Fill In The Blank": {
        "EASY": [
            { numb: 1, question: "Ano ang \"aso\" sa Agta?", answer: "aso" },
            { numb: 2, question: "Ano ang \"araw\" sa Agta?", answer: "aldew" },
            { numb: 3, question: "Ano ang \"tiyo\" sa Agta?", answer: "lele" },
            { numb: 4, question: "Ano ang \"makitasa\" sa Agta?", answer: "meta" },
            { numb: 5, question: "Ano ang \"kailan\" sa Agta?", answer: "kesya" }
        ],
        "MEDIUM": [
            { numb: 1, question: "Ano ang \"araw\" sa Agta?", answer: "araw" },
            { numb: 2, question: "Ano ang \"magkano\" sa Agta?", answer: "sanganya" },
            { numb: 3, question: "Ano ang \"alin\" sa agta?", answer: "nahe" },
            { numb: 4, question: "Ano ang \"malapit\" sa Agta?", answer: "asadek" },
            { numb: 5, question: "Ano ang \"tatay\" sa Agta?", answer: "ameng" }
        ],
        "HARD": [
            { numb: 1, question: "Ano ang \"dibdib\" sa Agta?", answer: "hako" },
            { numb: 2, question: "Ano ang \"pamangkin\" sa Agta?", answer: "aneng" },
            { numb: 3, question: "Ano ang \"marinig\" sa Agta?", answer: "mabate" },
            { numb: 4, question: "Ano ang \"tumayo\" sa Agta?", answer: "tumakneg" },
            { numb: 5, question: "Ano ang \"bunso\" sa Agta?", answer: "depos" }
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
