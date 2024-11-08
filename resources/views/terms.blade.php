@extends('layouts.public')

@section('content')
    <div class="main">
        <div class="container mx-auto px-4 py-8">
            <h1 class="text-center text-3xl font-bold">Terms of Use</h1>
            <p class="mt-4 text-center text-gray-600">Last updated: Friday, November 8, 2024</p>
            <div class="mt-8" id="terms">
                <h2 class="text-2xl font-bold">Terms</h2>
                <p class="mt-4 text-lg text-gray-600">
                    By accessing this website, you are agreeing to be bound by these website Terms and Conditions of
                    Use, all applicable laws and regulations, and agree that you are responsible for compliance with any
                    applicable local laws. If you do not agree with any of these terms, you are prohibited from using or
                    accessing this site. The materials contained in this website are protected by applicable copyright
                    and trademark law.
                </p>
            </div>
            <div class="mt-20" id="use-license">
                <h2 class="text-2xl font-bold">Use License</h2>
                <ol class="mt-4 list-decimal text-lg text-gray-600">
                    <li>
                        Permission is granted to temporarily download one copy of the materials (information or
                        software) on Yapper Hub's website for personal, non-commercial transitory viewing only. This is
                        the grant of a license, not a transfer of title, and under this license you may not:
                        <ol class="ml-4 list-decimal text-lg">
                            <li>Modify or copy the materials;</li>
                            <li>
                                Use the materials for any commercial purpose, or for any public display (commercial or
                                non-commercial);
                            </li>
                            <li>
                                Attempt to decompile or reverse engineer any software contained on Yapper Hub's website;
                            </li>
                            <li>Remove any copyright or other proprietary notations from the materials; or</li>
                            <li>
                                Transfer the materials to another person or "mirror" the materials on any other server.
                            </li>
                        </ol>
                    </li>
                    <li>
                        This license shall automatically terminate if you violate any of these restrictions and may be
                        terminated by Yapper Hub at any time. Upon terminating your viewing of these materials or upon
                        the termination of this license, you must destroy any downloaded materials in your possession
                        whether in electronic or printed format.
                    </li>
                </ol>
            </div>
            <div class="mt-20" id="disclaimer">
                <h2 class="text-2xl font-bold">Disclaimer</h2>
                <p class="mt-4 text-lg text-gray-600">
                    The materials on Yapper Hub's website are provided on an 'as is' basis. Yapper Hub makes no
                    warranties, expressed or implied, and hereby disclaims and negates all other warranties including,
                    without limitation, implied warranties or conditions of merchantability, fitness for a particular
                    purpose, or non-infringement of intellectual property or other violation of rights.
                </p>
            </div>
        </div>
        @include('partials.footer')
    </div>
@endsection
