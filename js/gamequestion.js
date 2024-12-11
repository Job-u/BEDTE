
const questions = [
    {
        numb:1,
        easyquestion:"Ano ang aso sa Agta?",
        answer:"B. Aso",
        option:[
            "A. Layon",
            "B. Aso",
            "C. atong",
            "D. Init"
            
        ]

    },
    {
        numb:2,
        easyquestion:"Ano ang gulay sa Agta??",
        answer:"C. atong",
        option:[
            "A. Layon",
            "B. Aso",
            "C. atong",
            "D. Init"
            
        ]

    },
    {
        numb:3,
        easyquestion:"Ano ang isa sa Agta??",
        answer:"B. esa",
        option:[
           "A. Layon",
            "B. esa",
            "C. Agent",
            "D. Init"
            
        ]

    },
    {
        numb:4,
        easyquestion:"Ano ang gabi sa Agta?",
        answer:"D. ganet",
        option:[ 
            "A. Layon",
            "B. lakas",
            "C. Agent",
            "D. ganet"
            
        ]

    },
    {
        numb:5,
        easyquestion:"Ano ang sikmura sa Agta?",
        answer:"A. gusok",
        option:[
            "A. gusok",
            "B. manko",
            "C. Agent",
            "D. puti"
            
        ]

    },


];

const mediumquestions = [
    {
        numb:1,
        mediumquestion:"Ano ang lupa sa Agta??",
        answer:"A. luta",
        medium:[
            "A. luta",
            "B. dila",
            "C. lasem",
            "D. multo"
            
        ]

    },
    {
        numb:2,
        mediumquestion:"Ano ang lupa sa Agta??",
        answer:"A. luta",
        medium:[
            "A. luta",
            "B. dila",
            "C. lasem",
            "D. multo"
            
        ]

    },
    {
        numb:3,
        mediumquestion:"Ano ang paa sa Agta??",
        answer:"B. tikéd",
        medium:[
           "A. singét",
            "B. tikéd",
            "C. parena",
            "D. ölöng"
            
        ]

    },
    {
        numb:4,
        mediumquestion:"Ano ang palay sa Agta? ?",
        answer:"C. pahay",
        medium:[ 
           "A. gusok",
            "B. manko",
            "C. pahay",
            "D. puti"
            
        ]

    },
    {
        numb:5,
        mediumquestion:"Ano ang bahag sa Agta? ?",
        answer:"D. beg",
        medium:[
           "A. kawil",
            "B. maige",
            "C. ahapay",
            "D. beg"
            
        ]

    },

  
];

const hardquestions = [
    {
        numb:1,
        hardquestion:"Ano ang bahag sa Agta ?",
        answer:"B. tidog",
        hard:[
            "A. ulito",
            "B. tidog",
            "C. wasek",
            "D. yogyog"
           

           
        ]

    },
    {
        numb:2,
        hardquestion:" Ano ang hati hati sa Agta ?",
        answer:"B. tukel",
        hard:[ 
            "A. gusok",
            "B. tukel",
            "C. udang",
            "D. puti"
            
        ]

    },
    {
        numb:3,
        hardquestion:"Ano ang binata sa Agta?",
        answer:"B. ulito",
        hard:[
          "A. busög",
            "B. ulito",
            "C. wasek",
            "D. yogyog"
            
        ]

    },
    {
        numb:4,
        hardquestion:"Ano ang hipon sa Agta ?",
        answer:"C. udang",
        hard:[ 
            "A. gusok",
            "B. manko",
            "C. udang",
            "D. puti"
            
        ]

    },
    {
        numb:5,
        hardquestion:"Ano ang unat sa Agta ?",
        answer:"D. uyan",
        hard:[
            "A. ulito",
            "B. tidog",
            "C. wasek",
            "D. uyan"
            
        ]

    },

    {
        numb:6,
        hardquestion:"Ano ang sapa sa Agta?",
        answer:"B. wanga",
        hard:[
            "A. gusok",
            "B. wanga",
            "C. pahay",
            "D. puti"
            
           

        
        ]

    },
    {
        numb:7,
        hardquestion:"Ano ang wisik sa Agta ?",
        answer:"A. wasek",
        hard:[
            "A. wasek",
            "B. manko",
            "C. pahay",
            "D. yamut"
            
        ]

    },
    {
        numb:8,
        hardquestion:"Ano ang lugar sa Agta?",
        answer:"B. banwan",
        hard:[
            "A. gusok",
            "B. banwan",
            "C. wasek",
            "D. puti"
            
            
        ]

    },
    {
        numb:9,
        hardquestion:"Ano ang duyan sa Agta ?",
        answer:"C. kéhay",
        hard:[ 
           "A. Layon",
            "B. esa",
            "C. kéhay",
            "D. Init"
        ]

    },
    {
        numb:10,
        hardquestion:"Ano ang inis sa Agta ?",
        answer:"D. yamut",
        hard:[
            "A. gusok",
            "B. manko",
            "C. pahay",
            "D. yamut"
            
        ]

    },


];

const easyfillquestion = [
    {  numb: 1,
        easyquestions: "Ano ang aso sa Agta? ________ (Layon, Aso, Agent, Init)",
        answer: "Aso", 
 },
    {
        numb: 2,
        easyquestions: "Ano ang inis sa Agta? ________ (inis, Aso ,yamut, Init) ", 
        answer: "yamut", 
       
    },
    {
        numb: 3,
        easyquestions: "Ano ang duyan sa Agta? ________ (Layon, yamut, Agent, kehay) ", 
        answer: "kehay", 
       
    },
    {
        numb: 4,
        easyquestions: "Ano ang lugar sa Agta? ________ (banwan, kehay, yamut, Init) ", 
        answer: "banwan", 
        
    },
    {
        numb: 5,
        easyquestions: "Ano ang wisik sa Agta? ________ (Aso, wasek ,Agent, yamut) ", 
        answer: "wasek", 
    
    }
];

const mediumfillquestion = [
    {  numb: 1,mediumblanksquestions: "what ang lupa sa Agta? ________ (yamut, Aso ,luta, wasek)",
         answer: "luta", 

     },
    {
        numb: 2,
        mediumblanksquestions: "what ang aso sa Agta? ________ (Layon ,Aso ,Agent, Init) ", 
        answer: "B", 
       
    },
    {
        numb: 3,
        mediumblanksquestions: "what ang aso sa Agta? ________ (Layon ,Aso ,Agent ,Init) ", 
        answer: "C", 
       
    },
    {
        numb: 4,
        mediumblanksquestions: "what ang  Spelling ng  binata sa agta?  ( touli ,ulito ,ulito ,ulito) ", 
        answer: "D", 
        
    },
    {
        numb: 5,
        mediumblanksquestions: "what ang aso sa Agta? ________ (Layon, Aso, Agent, Init) ", 
        answer: "F", 
    
    }
];
const hardfillquestion = [
    {  numb: 1,
        hardblanksquestions: "how ang aso sa Agta? ________ (Layon,Aso,Agent, Init)",
         answer: "a", 

     },
    {
        numb: 2,
        hardblanksquestions: "how ang aso sa Agta? ________ (Layon ,Aso ,Agent ,Init) ", 
        answer: "b", 
       
    },
    {
        numb: 3,
        hardblanksquestions: "how ang aso sa Agta? ________ (Layon, Aso ,Agent,Init) ", 
        answer: "c", 
       
    },
    {
        numb: 4,
        hardblanksquestions: "how ang aso sa Agta? ________ (Layon ,Aso, Agent ,Init) ", 
        answer: "d", 
        
    },
    {
        numb: 5,
        hardblanksquestions: "how ang aso sa Agta? ________ (Layon ,Aso ,Agent ,Init) ", 
        answer: "e", 
    
    },
    {  numb: 6,
        hardblanksquestions: "how ang aso sa Agta? ________ (Layon,Aso,Agent, Init)",
         answer: "f", 

     },
    {
        numb: 7,
        hardblanksquestions: "how ang aso sa Agta? ________ (Layon ,Aso ,Agent ,Init) ", 
        answer: "g", 
       
    },
    {
        numb: 8,
        hardblanksquestions: "how ang aso sa Agta? ________ (Layon, Aso ,Agent,Init) ", 
        answer: "h", 
       
    },
    {
        numb: 9,
        hardblanksquestions: "how ang aso sa Agta? ________ (Layon ,Aso, Agent ,Init) ", 
        answer: "i", 
        
    },
    {
        numb: 10,
        hardblanksquestions: "how ang aso sa Agta? ________ (Layon ,Aso ,Agent ,Init) ", 
        answer: "j", 
    
    }
]
