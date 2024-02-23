export default function Magnify(){
    $(document).ready(function() {
        $('.zoom').magnify({
            magnifiedWidth: 700,
            magnifiedHeight: 700,
            touchBottomOffset: 90,
        });
    });
}