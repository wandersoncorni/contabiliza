<div class="row">
    <div class="col-12 col-xl-8">
        <div class="card card-body border-0 shadow mb-4">
            <h2 class="h5 mb-4">General information</h2>
            <form>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div><label for="first_name">First Name</label> <input class="form-control" id="first_name" type="text" placeholder="Enter your first name" required=""></div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div><label for="last_name">Last Name</label> <input class="form-control" id="last_name" type="text" placeholder="Also your last name" required=""></div>
                    </div>
                </div>
                <div class="row align-items-center">
                    <div class="col-md-6 mb-3"><label for="birthday">Birthday</label>
                        <div class="input-group"><span class="input-group-text"><svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                </svg> </span><input data-datepicker="" class="form-control datepicker-input" id="birthday" type="text" placeholder="dd/mm/yyyy" required=""></div>
                    </div>
                    <div class="col-md-6 mb-3"><label for="gender">Gender</label> <select class="form-select mb-0" id="gender" aria-label="Gender select example">
                            <option selected="selected">Gender</option>
                            <option value="1">Female</option>
                            <option value="2">Male</option>
                        </select></div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="form-group"><label for="email">Email</label> <input class="form-control" id="email" type="email" placeholder="name@company.com" required=""></div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-group"><label for="phone">Phone</label> <input class="form-control" id="phone" type="number" placeholder="+12-345 678 910" required=""></div>
                    </div>
                </div>
                <h2 class="h5 my-4">Location</h2>
                <div class="row">
                    <div class="col-sm-9 mb-3">
                        <div class="form-group"><label for="address">Address</label> <input class="form-control" id="address" type="text" placeholder="Enter your home address" required=""></div>
                    </div>
                    <div class="col-sm-3 mb-3">
                        <div class="form-group"><label for="number">Number</label> <input class="form-control" id="number" type="number" placeholder="No." required=""></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4 mb-3">
                        <div class="form-group"><label for="city">City</label> <input class="form-control" id="city" type="text" placeholder="City" required=""></div>
                    </div>
                    <div class="col-sm-4 mb-3"><label for="state">State</label>
                        <div class="choices" data-type="select-one" role="combobox" tabindex="0" aria-autocomplete="list" aria-haspopup="true" aria-expanded="false" dir="ltr">
                            <div class="choices__inner"><select class="form-select w-100 mb-0 choices__input is-hidden" id="state" name="state" aria-label="State select example" tabindex="-1" aria-hidden="true" data-choice="active">
                                    <option value="State" selected="">State</option>
                                </select>
                                <div class="choices__list choices__list--single">
                                    <div class="choices__item choices__item--selectable" data-item="" data-id="1" data-value="State" aria-selected="true">
                                        State
                                    </div>
                                </div>
                            </div>
                            <div class="choices__list choices__list--dropdown" aria-expanded="false"><input type="text" class="choices__input choices__input--cloned" autocomplete="off" autocapitalize="none" spellcheck="false" role="textbox" aria-autocomplete="list" placeholder="">
                                <div class="choices__list" dir="ltr" role="listbox">
                                    <div class="choices__item choices__item--choice choices__item--selectable is-highlighted" data-select-text="Press to select" data-choice="" data-id="1" data-value="AL" data-choice-selectable="" id="choices--state-item-choice-1" role="option" aria-selected="true">
                                        Alabama
                                    </div>
                                    <div class="choices__item choices__item--choice choices__item--selectable" data-select-text="Press to select" data-choice="" data-id="2" data-value="AK" data-choice-selectable="" id="choices--state-item-choice-2" role="option">
                                        Alaska
                                    </div>
                                    <div class="choices__item choices__item--choice choices__item--selectable" data-select-text="Press to select" data-choice="" data-id="3" data-value="AZ" data-choice-selectable="" id="choices--state-item-choice-3" role="option">
                                        Arizona
                                    </div>
                                    <div class="choices__item choices__item--choice choices__item--selectable" data-select-text="Press to select" data-choice="" data-id="4" data-value="AR" data-choice-selectable="" id="choices--state-item-choice-4" role="option">
                                        Arkansas
                                    </div>
                                    <div class="choices__item choices__item--choice choices__item--selectable" data-select-text="Press to select" data-choice="" data-id="5" data-value="CA" data-choice-selectable="" id="choices--state-item-choice-5" role="option">
                                        California
                                    </div>
                                    <div class="choices__item choices__item--choice choices__item--selectable" data-select-text="Press to select" data-choice="" data-id="6" data-value="CO" data-choice-selectable="" id="choices--state-item-choice-6" role="option">
                                        Colorado
                                    </div>
                                    <div class="choices__item choices__item--choice choices__item--selectable" data-select-text="Press to select" data-choice="" data-id="7" data-value="CT" data-choice-selectable="" id="choices--state-item-choice-7" role="option">
                                        Connecticut
                                    </div>
                                    <div class="choices__item choices__item--choice choices__item--selectable" data-select-text="Press to select" data-choice="" data-id="8" data-value="DE" data-choice-selectable="" id="choices--state-item-choice-8" role="option">
                                        Delaware
                                    </div>
                                    <div class="choices__item choices__item--choice choices__item--selectable" data-select-text="Press to select" data-choice="" data-id="9" data-value="DC" data-choice-selectable="" id="choices--state-item-choice-9" role="option">
                                        District Of Columbia
                                    </div>
                                    <div class="choices__item choices__item--choice choices__item--selectable" data-select-text="Press to select" data-choice="" data-id="10" data-value="FL" data-choice-selectable="" id="choices--state-item-choice-10" role="option">
                                        Florida
                                    </div>
                                    <div class="choices__item choices__item--choice choices__item--selectable" data-select-text="Press to select" data-choice="" data-id="11" data-value="GA" data-choice-selectable="" id="choices--state-item-choice-11" role="option">
                                        Georgia
                                    </div>
                                    <div class="choices__item choices__item--choice choices__item--selectable" data-select-text="Press to select" data-choice="" data-id="12" data-value="HI" data-choice-selectable="" id="choices--state-item-choice-12" role="option">
                                        Hawaii
                                    </div>
                                    <div class="choices__item choices__item--choice choices__item--selectable" data-select-text="Press to select" data-choice="" data-id="13" data-value="ID" data-choice-selectable="" id="choices--state-item-choice-13" role="option">
                                        Idaho
                                    </div>
                                    <div class="choices__item choices__item--choice choices__item--selectable" data-select-text="Press to select" data-choice="" data-id="14" data-value="IL" data-choice-selectable="" id="choices--state-item-choice-14" role="option">
                                        Illinois
                                    </div>
                                    <div class="choices__item choices__item--choice choices__item--selectable" data-select-text="Press to select" data-choice="" data-id="15" data-value="IN" data-choice-selectable="" id="choices--state-item-choice-15" role="option">
                                        Indiana
                                    </div>
                                    <div class="choices__item choices__item--choice choices__item--selectable" data-select-text="Press to select" data-choice="" data-id="16" data-value="IA" data-choice-selectable="" id="choices--state-item-choice-16" role="option">
                                        Iowa
                                    </div>
                                    <div class="choices__item choices__item--choice choices__item--selectable" data-select-text="Press to select" data-choice="" data-id="17" data-value="KS" data-choice-selectable="" id="choices--state-item-choice-17" role="option">
                                        Kansas
                                    </div>
                                    <div class="choices__item choices__item--choice choices__item--selectable" data-select-text="Press to select" data-choice="" data-id="18" data-value="KY" data-choice-selectable="" id="choices--state-item-choice-18" role="option">
                                        Kentucky
                                    </div>
                                    <div class="choices__item choices__item--choice choices__item--selectable" data-select-text="Press to select" data-choice="" data-id="19" data-value="LA" data-choice-selectable="" id="choices--state-item-choice-19" role="option">
                                        Louisiana
                                    </div>
                                    <div class="choices__item choices__item--choice choices__item--selectable" data-select-text="Press to select" data-choice="" data-id="20" data-value="ME" data-choice-selectable="" id="choices--state-item-choice-20" role="option">
                                        Maine
                                    </div>
                                    <div class="choices__item choices__item--choice choices__item--selectable" data-select-text="Press to select" data-choice="" data-id="21" data-value="MD" data-choice-selectable="" id="choices--state-item-choice-21" role="option">
                                        Maryland
                                    </div>
                                    <div class="choices__item choices__item--choice choices__item--selectable" data-select-text="Press to select" data-choice="" data-id="22" data-value="MA" data-choice-selectable="" id="choices--state-item-choice-22" role="option">
                                        Massachusetts
                                    </div>
                                    <div class="choices__item choices__item--choice choices__item--selectable" data-select-text="Press to select" data-choice="" data-id="23" data-value="MI" data-choice-selectable="" id="choices--state-item-choice-23" role="option">
                                        Michigan
                                    </div>
                                    <div class="choices__item choices__item--choice choices__item--selectable" data-select-text="Press to select" data-choice="" data-id="24" data-value="MN" data-choice-selectable="" id="choices--state-item-choice-24" role="option">
                                        Minnesota
                                    </div>
                                    <div class="choices__item choices__item--choice choices__item--selectable" data-select-text="Press to select" data-choice="" data-id="25" data-value="MS" data-choice-selectable="" id="choices--state-item-choice-25" role="option">
                                        Mississippi
                                    </div>
                                    <div class="choices__item choices__item--choice choices__item--selectable" data-select-text="Press to select" data-choice="" data-id="26" data-value="MO" data-choice-selectable="" id="choices--state-item-choice-26" role="option">
                                        Missouri
                                    </div>
                                    <div class="choices__item choices__item--choice choices__item--selectable" data-select-text="Press to select" data-choice="" data-id="27" data-value="MT" data-choice-selectable="" id="choices--state-item-choice-27" role="option">
                                        Montana
                                    </div>
                                    <div class="choices__item choices__item--choice choices__item--selectable" data-select-text="Press to select" data-choice="" data-id="28" data-value="NE" data-choice-selectable="" id="choices--state-item-choice-28" role="option">
                                        Nebraska
                                    </div>
                                    <div class="choices__item choices__item--choice choices__item--selectable" data-select-text="Press to select" data-choice="" data-id="29" data-value="NV" data-choice-selectable="" id="choices--state-item-choice-29" role="option">
                                        Nevada
                                    </div>
                                    <div class="choices__item choices__item--choice choices__item--selectable" data-select-text="Press to select" data-choice="" data-id="30" data-value="NH" data-choice-selectable="" id="choices--state-item-choice-30" role="option">
                                        New Hampshire
                                    </div>
                                    <div class="choices__item choices__item--choice choices__item--selectable" data-select-text="Press to select" data-choice="" data-id="31" data-value="NJ" data-choice-selectable="" id="choices--state-item-choice-31" role="option">
                                        New Jersey
                                    </div>
                                    <div class="choices__item choices__item--choice choices__item--selectable" data-select-text="Press to select" data-choice="" data-id="32" data-value="NM" data-choice-selectable="" id="choices--state-item-choice-32" role="option">
                                        New Mexico
                                    </div>
                                    <div class="choices__item choices__item--choice choices__item--selectable" data-select-text="Press to select" data-choice="" data-id="33" data-value="NY" data-choice-selectable="" id="choices--state-item-choice-33" role="option">
                                        New York
                                    </div>
                                    <div class="choices__item choices__item--choice choices__item--selectable" data-select-text="Press to select" data-choice="" data-id="34" data-value="NC" data-choice-selectable="" id="choices--state-item-choice-34" role="option">
                                        North Carolina
                                    </div>
                                    <div class="choices__item choices__item--choice choices__item--selectable" data-select-text="Press to select" data-choice="" data-id="35" data-value="ND" data-choice-selectable="" id="choices--state-item-choice-35" role="option">
                                        North Dakota
                                    </div>
                                    <div class="choices__item choices__item--choice choices__item--selectable" data-select-text="Press to select" data-choice="" data-id="36" data-value="OH" data-choice-selectable="" id="choices--state-item-choice-36" role="option">
                                        Ohio
                                    </div>
                                    <div class="choices__item choices__item--choice choices__item--selectable" data-select-text="Press to select" data-choice="" data-id="37" data-value="OK" data-choice-selectable="" id="choices--state-item-choice-37" role="option">
                                        Oklahoma
                                    </div>
                                    <div class="choices__item choices__item--choice choices__item--selectable" data-select-text="Press to select" data-choice="" data-id="38" data-value="OR" data-choice-selectable="" id="choices--state-item-choice-38" role="option">
                                        Oregon
                                    </div>
                                    <div class="choices__item choices__item--choice choices__item--selectable" data-select-text="Press to select" data-choice="" data-id="39" data-value="PA" data-choice-selectable="" id="choices--state-item-choice-39" role="option">
                                        Pennsylvania
                                    </div>
                                    <div class="choices__item choices__item--choice choices__item--selectable" data-select-text="Press to select" data-choice="" data-id="40" data-value="RI" data-choice-selectable="" id="choices--state-item-choice-40" role="option">
                                        Rhode Island
                                    </div>
                                    <div class="choices__item choices__item--choice choices__item--selectable" data-select-text="Press to select" data-choice="" data-id="41" data-value="SC" data-choice-selectable="" id="choices--state-item-choice-41" role="option">
                                        South Carolina
                                    </div>
                                    <div class="choices__item choices__item--choice choices__item--selectable" data-select-text="Press to select" data-choice="" data-id="42" data-value="SD" data-choice-selectable="" id="choices--state-item-choice-42" role="option">
                                        South Dakota
                                    </div>
                                    <div class="choices__item choices__item--choice choices__item--selectable" data-select-text="Press to select" data-choice="" data-id="43" data-value="State" data-choice-selectable="" id="choices--state-item-choice-43" role="option">
                                        State
                                    </div>
                                    <div class="choices__item choices__item--choice choices__item--selectable" data-select-text="Press to select" data-choice="" data-id="44" data-value="TN" data-choice-selectable="" id="choices--state-item-choice-44" role="option">
                                        Tennessee
                                    </div>
                                    <div class="choices__item choices__item--choice choices__item--selectable" data-select-text="Press to select" data-choice="" data-id="45" data-value="TX" data-choice-selectable="" id="choices--state-item-choice-45" role="option">
                                        Texas
                                    </div>
                                    <div class="choices__item choices__item--choice choices__item--selectable" data-select-text="Press to select" data-choice="" data-id="46" data-value="UT" data-choice-selectable="" id="choices--state-item-choice-46" role="option">
                                        Utah
                                    </div>
                                    <div class="choices__item choices__item--choice choices__item--selectable" data-select-text="Press to select" data-choice="" data-id="47" data-value="VT" data-choice-selectable="" id="choices--state-item-choice-47" role="option">
                                        Vermont
                                    </div>
                                    <div class="choices__item choices__item--choice choices__item--selectable" data-select-text="Press to select" data-choice="" data-id="48" data-value="VA" data-choice-selectable="" id="choices--state-item-choice-48" role="option">
                                        Virginia
                                    </div>
                                    <div class="choices__item choices__item--choice choices__item--selectable" data-select-text="Press to select" data-choice="" data-id="49" data-value="WA" data-choice-selectable="" id="choices--state-item-choice-49" role="option">
                                        Washington
                                    </div>
                                    <div class="choices__item choices__item--choice choices__item--selectable" data-select-text="Press to select" data-choice="" data-id="50" data-value="WV" data-choice-selectable="" id="choices--state-item-choice-50" role="option">
                                        West Virginia
                                    </div>
                                    <div class="choices__item choices__item--choice choices__item--selectable" data-select-text="Press to select" data-choice="" data-id="51" data-value="WI" data-choice-selectable="" id="choices--state-item-choice-51" role="option">
                                        Wisconsin
                                    </div>
                                    <div class="choices__item choices__item--choice choices__item--selectable" data-select-text="Press to select" data-choice="" data-id="52" data-value="WY" data-choice-selectable="" id="choices--state-item-choice-52" role="option">
                                        Wyoming
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group"><label for="zip">ZIP</label> <input class="form-control" id="zip" type="tel" placeholder="ZIP" required=""></div>
                    </div>
                </div>
                <div class="mt-3"><button class="btn btn-gray-800 mt-2 animate-up-2" type="submit">Save all</button></div>
            </form>
        </div>
        <div class="card card-body border-0 shadow mb-4 mb-xl-0">
            <h2 class="h5 mb-4">Alerts &amp; Notifications</h2>
            <ul class="list-group list-group-flush">
                <li class="list-group-item d-flex align-items-center justify-content-between px-0 border-bottom">
                    <div>
                        <h3 class="h6 mb-1">Company News</h3>
                        <p class="small pe-4">Get Rocket news, announcements, and product updates</p>
                    </div>
                    <div>
                        <div class="form-check form-switch"><input class="form-check-input" type="checkbox" id="user-notification-1"> <label class="form-check-label" for="user-notification-1"></label></div>
                    </div>
                </li>
                <li class="list-group-item d-flex align-items-center justify-content-between px-0 border-bottom">
                    <div>
                        <h3 class="h6 mb-1">Account Activity</h3>
                        <p class="small pe-4">Get important notifications about you or activity you've missed</p>
                    </div>
                    <div>
                        <div class="form-check form-switch"><input class="form-check-input" type="checkbox" id="user-notification-2" checked="checked"> <label class="form-check-label" for="user-notification-2"></label></div>
                    </div>
                </li>
                <li class="list-group-item d-flex align-items-center justify-content-between px-0">
                    <div>
                        <h3 class="h6 mb-1">Meetups Near You</h3>
                        <p class="small pe-4">Get an email when a Dribbble Meetup is posted close to my location</p>
                    </div>
                    <div>
                        <div class="form-check form-switch"><input class="form-check-input" type="checkbox" id="user-notification-3" checked="checked"> <label class="form-check-label" for="user-notification-3"></label></div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <div class="col-12 col-xl-4">
        <div class="row">
            <div class="col-12">
                <div class="card card-body border-0 shadow mb-4">
                    <h2 class="h5 mb-4">Select profile photo</h2>
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <!-- Avatar --> <img class="rounded avatar-xl" src="../assets/img/team/profile-picture-3.jpg" alt="change avatar"></div>
                        <div class="file-field">
                            <div class="d-flex justify-content-xl-center ms-xl-3">
                                <div class="d-flex"><svg class="icon text-gray-500 me-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M8 4a3 3 0 00-3 3v4a5 5 0 0010 0V7a1 1 0 112 0v4a7 7 0 11-14 0V7a5 5 0 0110 0v4a3 3 0 11-6 0V7a1 1 0 012 0v4a1 1 0 102 0V7a3 3 0 00-3-3z" clip-rule="evenodd"></path>
                                    </svg> <input type="file">
                                    <div class="d-md-block text-left">
                                        <div class="fw-normal text-dark mb-1">Choose Image</div>
                                        <div class="text-gray small">JPG, GIF or PNG. Max size of 800K</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-xl-12">
                <form action="/file-upload" class="dropzone rounded mb-4 dz-clickable">
                    <div class="dz-default dz-message"><button class="dz-button" type="button">Drop files here to upload</button></div>
                </form>
            </div>
            <div class="col-12 col-sm-6 col-xl-12">
                <div class="card card-body border-0 shadow mb-4">
                    <h2 class="h5 mb-4">Select cover photo</h2>
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <!-- Avatar --> <img class="rounded avatar-xl" src="../assets/img/profile-cover.jpg" alt="change cover"></div>
                        <div class="file-field">
                            <div class="d-flex justify-content-xl-center ms-xl-3">
                                <div class="d-flex"><svg class="icon text-gray-500 me-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M8 4a3 3 0 00-3 3v4a5 5 0 0010 0V7a1 1 0 112 0v4a7 7 0 11-14 0V7a5 5 0 0110 0v4a3 3 0 11-6 0V7a1 1 0 012 0v4a1 1 0 102 0V7a3 3 0 00-3-3z" clip-rule="evenodd"></path>
                                    </svg> <input type="file">
                                    <div class="d-md-block text-left">
                                        <div class="fw-normal text-dark mb-1">Choose Image</div>
                                        <div class="text-gray small">JPG, GIF or PNG. Max size of 800K</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>