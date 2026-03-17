

<div class="mb-5">


    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center text-gray-500 dark:text-gray-400">







            <li class="me-2">
                <a href="{{route('admin.settings.info')}}"
                   class="inline-flex items-center justify-center p-4 border-b-2 rounded-t-lg group
                               @if( $activeTab ==='info' )
                                    'text-blue-600 border-blue-600 dark:text-blue-500 dark:border-blue-500'
                                  @else 'border-transparent text-gray-400hover:text-gray-600
                                  hover:border-gray-300 dark:hover:text-gray-300' @endif">
                    {{ __('My Profile') }}
                </a>
            </li>

            @can('admin.settings.general')
                <li class="me-2">
                    <a href="{{route('admin.settings.general')}}"
                       class="inline-flex items-center justify-center p-4 border-b-2 rounded-t-lg group
                               @if( $activeTab ==='generally' )
                                    'text-blue-600 border-blue-600 dark:text-blue-500 dark:border-blue-500'
                                  @else 'border-transparent text-gray-400hover:text-gray-600
                                  hover:border-gray-300 dark:hover:text-gray-300' @endif">
                        {{ __('Generally') }}
                    </a>
                </li>
          @endcan








                @can('admin.settings.smtp')
                <li class="me-2">
                    <a href="{{route('admin.settings.smtp')}}"
                       class="inline-flex items-center justify-center p-4 border-b-2 rounded-t-lg group
                             @if( $activeTab ==='smtp' )
                                'text-blue-600 border-blue-600 dark:text-blue-500 dark:border-blue-500'
                              @else 'border-transparent text-gray-400 hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300' @endif">

                        {{ __('SMTP') }}
                    </a>
                </li>
                @endcan


                @can('admin.settings.api_token')
           <li class="me-2">
                    <a href="{{route('admin.settings.api_token')}}"
                       class="inline-flex items-center justify-center p-4 border-b-2 rounded-t-lg group
                             @if( $activeTab ==='api_token' )
                                'text-blue-600 border-blue-600 dark:text-blue-500 dark:border-blue-500'
                              @else 'border-transparent text-gray-400 hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300' @endif">

                        {{ __('API Key') }}
                    </a>
                </li>
                @endcan






                @can('admin.settings.performance')
                    <li class="me-2">
                        <a href="{{route('admin.settings.performance')}}"
                           class="inline-flex items-center justify-center p-4 border-b-2 rounded-t-lg group
                                 @if( $activeTab ==='performance' )
                                    'text-blue-600 border-blue-600 dark:text-blue-500 dark:border-blue-500'
                                  @else 'border-transparent text-gray-400hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300' @endif">

                            {{ __('Performance') }}
                        </a>
                    </li>
                @endcan

            @can('admin.settings.interfaces')
                <li class="me-2">
                    <a href="{{route('admin.settings.interfaces')}}"
                       class="inline-flex items-center justify-center p-4 border-b-2 rounded-t-lg group
                                     @if( $activeTab ==='interface' )
                                        'text-blue-600 border-blue-600 dark:text-blue-500 dark:border-blue-500'
                                      @else 'border-transparent text-gray-400hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300' @endif">

                        {{ __('Interfaces') }}
                    </a>
                </li>

            @endcan








    </ul>
</div>
