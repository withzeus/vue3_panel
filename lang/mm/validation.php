<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => ':attribute ကို လက်ခံရပါမည်။',
    'accepted_if' => ':other သည် :value ဖြစ်ပါက :attribute ကို လက်ခံရပါမည်။',
    'active_url' => ':attribute သည် မှန်ကန်သော URL ဖြစ်ရပါမည်။',
    'after' => ':attribute သည် :date နောက်ပိုင်း ရက်စွဲဖြစ်ရပါမည်။',
    'after_or_equal' => ':attribute သည် :date နှင့် တူညီသော သို့မဟုတ် နောက်ပိုင်း ရက်စွဲဖြစ်ရပါမည်။',
    'alpha' => ':attribute တွင် အက္ခရာများသာ ပါဝင်ရပါမည်။',
    'alpha_dash' => ':attribute တွင် အက္ခရာများ၊ ဂဏန်းများ၊ ဒက်ရှ် (-) နှင့် အောက်မျဉ်း (_) များသာ ပါဝင်ရပါမည်။',
    'alpha_num' => ':attribute တွင် အက္ခရာများနှင့် ဂဏန်းများသာ ပါဝင်ရပါမည်။',
    'any_of' => ':attribute သည် မမှန်ကန်ပါ။',
    'array' => ':attribute သည် Array အမျိုးအစားဖြစ်ရပါမည်။',
    'ascii' => ':attribute တွင် ASCII အက္ခရာများနှင့် သင်္ကေတများသာ ပါဝင်ရပါမည်။',
    'before' => ':attribute သည် :date မတိုင်မီ ရက်စွဲဖြစ်ရပါမည်။',
    'before_or_equal' => ':attribute သည် :date နှင့် တူညီသော သို့မဟုတ် မတိုင်မီ ရက်စွဲဖြစ်ရပါမည်။',
    'between' => [
        'array' => ':attribute တွင် :min မှ :max အထိ အချက်အလက်များ ပါဝင်ရပါမည်။',
        'file' => ':attribute သည် :min KB မှ :max KB အတွင်း ရှိရပါမည်။',
        'numeric' => ':attribute သည် :min နှင့် :max အကြား ဖြစ်ရပါမည်။',
        'string' => ':attribute သည် စာလုံးရေ :min မှ :max အတွင်း ဖြစ်ရပါမည်။',
    ],
    'boolean' => ':attribute သည် true သို့မဟုတ် false ဖြစ်ရပါမည်။',
    'can' => ':attribute တွင် ခွင့်မပြုထားသော တန်ဖိုး ပါဝင်နေပါသည်။',
    'confirmed' => ':attribute အတည်ပြုချက် မကိုက်ညီပါ။',
    'contains' => ':attribute တွင် လိုအပ်သော တန်ဖိုးတစ်ခု မပါဝင်ပါ။',
    'current_password' => 'လက်ရှိ စကားဝှက် မှားယွင်းနေပါသည်။',
    'date' => ':attribute သည် မှန်ကန်သော ရက်စွဲဖြစ်ရပါမည်။',
    'date_equals' => ':attribute သည် :date နှင့် တူညီသော ရက်စွဲဖြစ်ရပါမည်။',
    'date_format' => ':attribute သည် :format ပုံစံနှင့် ကိုက်ညီရပါမည်။',
    'decimal' => ':attribute တွင် ဒဿမ :decimal နေရာ ရှိရပါမည်။',
    'declined' => ':attribute ကို ငြင်းပယ်ရပါမည်။',
    'declined_if' => ':other သည် :value ဖြစ်ပါက :attribute ကို ငြင်းပယ်ရပါမည်။',
    'different' => ':attribute နှင့် :other သည် မတူညီရပါမည်။',
    'digits' => ':attribute သည် ဂဏန်း :digits လုံး တိတိ ဖြစ်ရပါမည်။',
    'digits_between' => ':attribute သည် ဂဏန်း :min မှ :max လုံးအတွင်း ဖြစ်ရပါမည်။',
    'dimensions' => ':attribute ၏ ပုံအရွယ်အစား မမှန်ကန်ပါ။',
    'distinct' => ':attribute တွင် ထပ်နေသော တန်ဖိုး ရှိနေပါသည်။',
    'doesnt_contain' => ':attribute တွင် အောက်ပါတန်ဖိုးများ မပါဝင်ရပါ- :values။',
    'doesnt_end_with' => ':attribute သည် အောက်ပါတန်ဖိုးများဖြင့် အဆုံးမသတ်ရပါ- :values။',
    'doesnt_start_with' => ':attribute သည် အောက်ပါတန်ဖိုးများဖြင့် မစတင်ရပါ- :values။',
    'email' => ':attribute သည် မှန်ကန်သော အီးမေးလ်လိပ်စာ ဖြစ်ရပါမည်။',
    'encoding' => ':attribute ကို :encoding ဖြင့် encode လုပ်ထားရပါမည်။',
    'ends_with' => ':attribute သည် အောက်ပါတန်ဖိုးများထဲမှ တစ်ခုဖြင့် အဆုံးသတ်ရပါမည်- :values။',
    'enum' => 'ရွေးချယ်ထားသော :attribute သည် မမှန်ကန်ပါ။',
    'exists' => 'ရွေးချယ်ထားသော :attribute သည် မမှန်ကန်ပါ။',
    'extensions' => ':attribute သည် အောက်ပါ ဖိုင်အမျိုးအစားများထဲမှ တစ်ခု ဖြစ်ရပါမည်- :values။',
    'file' => ':attribute သည် ဖိုင်တစ်ခု ဖြစ်ရပါမည်။',
    'filled' => ':attribute တွင် တန်ဖိုးတစ်ခု ထည့်သွင်းရပါမည်။',
    'gt' => [
        'array' => ':attribute တွင် :value ခုထက်ပိုသော အချက်အလက်များ ပါဝင်ရပါမည်။',
        'file' => ':attribute သည် :value KB ထက် ကြီးရပါမည်။',
        'numeric' => ':attribute သည် :value ထက် ကြီးရပါမည်။',
        'string' => ':attribute သည် စာလုံးရေ :value ထက် ပိုရပါမည်။',
    ],
    'gte' => [
        'array' => ':attribute တွင် :value ခု သို့မဟုတ် ထို့ထက်ပိုသော အချက်အလက်များ ပါဝင်ရပါမည်။',
        'file' => ':attribute သည် :value KB နှင့် ညီမျှ သို့မဟုတ် ထို့ထက် ကြီးရပါမည်။',
        'numeric' => ':attribute သည် :value နှင့် ညီမျှ သို့မဟုတ် ထို့ထက် ကြီးရပါမည်။',
        'string' => ':attribute သည် စာလုံးရေ :value နှင့် ညီမျှ သို့မဟုတ် ထို့ထက် ပိုရပါမည်။',
    ],
    'hex_color' => ':attribute သည် မှန်ကန်သော Hexadecimal အရောင်ကုဒ် ဖြစ်ရပါမည်။',
    'image' => ':attribute သည် ပုံဖိုင်တစ်ခု ဖြစ်ရပါမည်။',
    'in' => 'ရွေးချယ်ထားသော :attribute သည် မမှန်ကန်ပါ။',
    'in_array' => ':attribute သည် :other တွင် ရှိရပါမည်။',
    'in_array_keys' => ':attribute တွင် အောက်ပါ key များထဲမှ အနည်းဆုံးတစ်ခု ပါဝင်ရပါမည်- :values။',
    'integer' => ':attribute သည် ကိန်းပြည့် (Integer) ဖြစ်ရပါမည်။',
    'ip' => ':attribute သည် မှန်ကန်သော IP လိပ်စာ ဖြစ်ရပါမည်။',
    'ipv4' => ':attribute သည် မှန်ကန်သော IPv4 လိပ်စာ ဖြစ်ရပါမည်။',
    'ipv6' => ':attribute သည် မှန်ကန်သော IPv6 လိပ်စာ ဖြစ်ရပါမည်။',
    'json' => ':attribute သည် မှန်ကန်သော JSON စာသား ဖြစ်ရပါမည်။',
    'list' => ':attribute သည် List အမျိုးအစား ဖြစ်ရပါမည်။',
    'lowercase' => ':attribute သည် စာလုံးအသေးများသာ ဖြစ်ရပါမည်။',
    'lt' => [
        'array' => ':attribute တွင် :value ခုထက် နည်းသော အချက်အလက်များ ပါဝင်ရပါမည်။',
        'file' => ':attribute သည် :value KB ထက် ငယ်ရပါမည်။',
        'numeric' => ':attribute သည် :value ထက် ငယ်ရပါမည်။',
        'string' => ':attribute သည် စာလုံးရေ :value ထက် နည်းရပါမည်။',
    ],
    'lte' => [
        'array' => ':attribute တွင် :value ခုထက် မပိုသော အချက်အလက်များ ပါဝင်ရပါမည်။',
        'file' => ':attribute သည် :value KB နှင့် ညီမျှ သို့မဟုတ် ထို့ထက် မကြီးရပါ။',
        'numeric' => ':attribute သည် :value နှင့် ညီမျှ သို့မဟုတ် ထို့ထက် မကြီးရပါ။',
        'string' => ':attribute သည် စာလုံးရေ :value နှင့် ညီမျှ သို့မဟုတ် ထို့ထက် မပိုရပါ။',
    ],
    'mac_address' => ':attribute သည် မှန်ကန်သော MAC လိပ်စာ ဖြစ်ရပါမည်။',
    'max' => [
        'array' => ':attribute တွင် :max ခုထက် ပိုသော အချက်အလက်များ မပါဝင်ရပါ။',
        'file' => ':attribute သည် :max KB ထက် မကြီးရပါ။',
        'numeric' => ':attribute သည် :max ထက် မကြီးရပါ။',
        'string' => ':attribute သည် စာလုံးရေ :max ထက် မပိုရပါ။',
    ],
    'max_digits' => ':attribute တွင် ဂဏန်း :max လုံးထက် မပိုရပါ။',
    'mimes' => ':attribute သည် အောက်ပါ ဖိုင်အမျိုးအစားများထဲမှ တစ်ခု ဖြစ်ရပါမည်- :values။',
    'mimetypes' => ':attribute သည် အောက်ပါ MIME အမျိုးအစားများထဲမှ တစ်ခု ဖြစ်ရပါမည်- :values။',
    'min' => [
        'array' => ':attribute တွင် အနည်းဆုံး :min ခုသော အချက်အလက်များ ပါဝင်ရပါမည်။',
        'file' => ':attribute သည် အနည်းဆုံး :min KB ရှိရပါမည်။',
        'numeric' => ':attribute သည် အနည်းဆုံး :min ဖြစ်ရပါမည်။',
        'string' => ':attribute သည် အနည်းဆုံး စာလုံးရေ :min လုံး ရှိရပါမည်။',
    ],
    'min_digits' => ':attribute တွင် အနည်းဆုံး ဂဏန်း :min လုံး ပါဝင်ရပါမည်။',
    'missing' => ':attribute မပါဝင်ရပါ။',
    'missing_if' => ':other သည် :value ဖြစ်ပါက :attribute မပါဝင်ရပါ။',
    'missing_unless' => ':other သည် :value မဟုတ်ပါက :attribute မပါဝင်ရပါ။',
    'missing_with' => ':values ပါဝင်ပါက :attribute မပါဝင်ရပါ။',
    'missing_with_all' => ':values အားလုံး ပါဝင်ပါက :attribute မပါဝင်ရပါ။',
    'multiple_of' => ':attribute သည် :value ၏ ဆတိုးကိန်း ဖြစ်ရပါမည်။',
    'not_in' => 'ရွေးချယ်ထားသော :attribute သည် မမှန်ကန်ပါ။',
    'not_regex' => ':attribute ၏ ပုံစံ မမှန်ကန်ပါ။',
    'numeric' => ':attribute သည် ဂဏန်းဖြစ်ရပါမည်။',
    'password' => [
        'letters' => ':attribute တွင် အနည်းဆုံး အက္ခရာတစ်လုံး ပါဝင်ရပါမည်။',
        'mixed' => ':attribute တွင် အနည်းဆုံး စာလုံးအကြီးတစ်လုံးနှင့် စာလုံးအသေးတစ်လုံး ပါဝင်ရပါမည်။',
        'numbers' => ':attribute တွင် အနည်းဆုံး ဂဏန်းတစ်လုံး ပါဝင်ရပါမည်။',
        'symbols' => ':attribute တွင် အနည်းဆုံး သင်္ကေတတစ်ခု ပါဝင်ရပါမည်။',
        'uncompromised' => 'ဤ :attribute သည် ပေါက်ကြားခဲ့သော အချက်အလက်များတွင် ပါဝင်နေပါသည်။ လုံခြုံရေးအတွက် အခြား :attribute ကို အသုံးပြုပါ။',
    ],
    'present' => ':attribute ကို ထည့်သွင်းရပါမည်။',
    'present_if' => ':other သည် :value ဖြစ်ပါက :attribute ကို ထည့်သွင်းရပါမည်။',
    'present_unless' => ':other သည် :value မဟုတ်ပါက :attribute ကို ထည့်သွင်းရပါမည်။',
    'present_with' => ':values ပါဝင်ပါက :attribute ကို ထည့်သွင်းရပါမည်။',
    'present_with_all' => ':values အားလုံး ပါဝင်ပါက :attribute ကို ထည့်သွင်းရပါမည်။',
    'prohibited' => ':attribute ကို ထည့်သွင်းခွင့်မပြုပါ။',
    'prohibited_if' => ':other သည် :value ဖြစ်ပါက :attribute ကို ထည့်သွင်းခွင့်မပြုပါ။',
    'prohibited_if_accepted' => ':other ကို လက်ခံထားပါက :attribute ကို ထည့်သွင်းခွင့်မပြုပါ။',
    'prohibited_if_declined' => ':other ကို ငြင်းပယ်ထားပါက :attribute ကို ထည့်သွင်းခွင့်မပြုပါ။',
    'prohibited_unless' => ':other သည် :values တွင် မပါဝင်ပါက :attribute ကို ထည့်သွင်းခွင့်မပြုပါ။',
    'prohibits' => ':attribute ရှိနေပါက :other ကို ထည့်သွင်းခွင့်မပြုပါ။',
    'regex' => ':attribute ၏ ပုံစံ မမှန်ကန်ပါ။',
    'required' => ':attribute ကို ဖြည့်သွင်းရန် လိုအပ်ပါသည်။',
    'required_array_keys' => ':attribute တွင် အောက်ပါ Key များ ပါဝင်ရပါမည်- :values။',
    'required_if' => ':other သည် :value ဖြစ်ပါက :attribute ကို ဖြည့်သွင်းရန် လိုအပ်ပါသည်။',
    'required_if_accepted' => ':other ကို လက်ခံထားပါက :attribute ကို ဖြည့်သွင်းရန် လိုအပ်ပါသည်။',
    'required_if_declined' => ':other ကို ငြင်းပယ်ထားပါက :attribute ကို ဖြည့်သွင်းရန် လိုအပ်ပါသည်။',
    'required_unless' => ':other သည် :values တွင် မပါဝင်ပါက :attribute ကို ဖြည့်သွင်းရန် လိုအပ်ပါသည်။',
    'required_with' => ':values ပါဝင်ပါက :attribute ကို ဖြည့်သွင်းရန် လိုအပ်ပါသည်။',
    'required_with_all' => ':values အားလုံး ပါဝင်ပါက :attribute ကို ဖြည့်သွင်းရန် လိုအပ်ပါသည်။',
    'required_without' => ':values မပါဝင်ပါက :attribute ကို ဖြည့်သွင်းရန် လိုအပ်ပါသည်။',
    'required_without_all' => ':values အားလုံး မပါဝင်ပါက :attribute ကို ဖြည့်သွင်းရန် လိုအပ်ပါသည်။',
    'same' => ':attribute သည် :other နှင့် တူညီရပါမည်။',
    'size' => [
        'array' => ':attribute တွင် :size ခုသော အချက်အလက်များ ပါဝင်ရပါမည်။',
        'file' => ':attribute သည် :size KB ရှိရပါမည်။',
        'numeric' => ':attribute သည် :size ဖြစ်ရပါမည်။',
        'string' => ':attribute သည် စာလုံးရေ :size လုံး ဖြစ်ရပါမည်။',
    ],
    'starts_with' => ':attribute သည် အောက်ပါတန်ဖိုးများထဲမှ တစ်ခုဖြင့် စတင်ရပါမည်- :values။',
    'string' => ':attribute သည် စာသား (String) ဖြစ်ရပါမည်။',
    'timezone' => ':attribute သည် မှန်ကန်သော အချိန်ဇုန် (Timezone) ဖြစ်ရပါမည်။',
    'unique' => ':attribute ကို အသုံးပြုပြီး ဖြစ်ပါသည်။',
    'uploaded' => ':attribute ကို အပ်လုဒ်တင်ရာတွင် မအောင်မြင်ပါ။',
    'uppercase' => ':attribute သည် စာလုံးအကြီးများသာ ဖြစ်ရပါမည်။',
    'url' => ':attribute သည် မှန်ကန်သော URL ဖြစ်ရပါမည်။',
    'ulid' => ':attribute သည် မှန်ကန်သော ULID ဖြစ်ရပါမည်။',
    'uuid' => ':attribute သည် မှန်ကန်သော UUID ဖြစ်ရပါမည်။',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */
    'attributes' => [
        'name' => 'အမည်',
        'username' => 'အသုံးပြုသူအမည်',
        'email' => 'အီးမေးလ်လိပ်စာ',
        'password' => 'စကားဝှက်',
        'password_confirmation' => 'စကားဝှက်အတည်ပြုခြင်း',
        'current_password' => 'လက်ရှိစကားဝှက်',
        'new_password' => 'စကားဝှက်အသစ်',
        'first_name' => 'ရှေ့အမည်',
        'last_name' => 'နောက်အမည်',
        'phone' => 'ဖုန်းနံပါတ်',
        'mobile' => 'မိုဘိုင်းဖုန်းနံပါတ်',
        'address' => 'လိပ်စာ',
        'city' => 'မြို့',
        'state' => 'တိုင်း/ပြည်နယ်',
        'country' => 'နိုင်ငံ',
        'postal_code' => 'စာတိုက်သင်္ကေတ',
        'zip' => 'စာတိုက်သင်္ကေတ',
        'age' => 'အသက်',
        'gender' => 'ကျား/မ',
        'birth_date' => 'မွေးသက္ကရာဇ်',
        'dob' => 'မွေးသက္ကရာဇ်',
        'title' => 'ခေါင်းစဉ်',
        'description' => 'ဖော်ပြချက်',
        'content' => 'အကြောင်းအရာ',
        'message' => 'မက်ဆေ့ချ်',
        'status' => 'အခြေအနေ',
        'role' => 'အခန်းကဏ္ဍ',
        'permission' => 'ခွင့်ပြုချက်',
        'image' => 'ပုံ',
        'photo' => 'ဓာတ်ပုံ',
        'avatar' => 'ကိုယ်စားပြုပုံ',
        'file' => 'ဖိုင်',
    ],
];
